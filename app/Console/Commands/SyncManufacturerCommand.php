<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncManufacturerCommand extends Command
{
    protected $signature = 'app:sync-manufacturers';
    protected $description = 'Sync all CAP manufacturers';

    public function handle()
    {
        $subscriberId             = config('services.hpi.subscriber_id');
        $password                 = config('services.hpi.password');
        $database                 = config('services.hpi.database');
        $justCurrentManufacturers = "True";
        $bodyStyleFilter          = "";

        $url = "https://soap.cap.co.uk/Vehicles/CapVehicles.asmx/GetCapMan?
            subscriberId={$subscriberId}
            &password={$password}
            &database={$database}
            &justCurrentManufacturers={$justCurrentManufacturers}
            &bodyStyleFilter={$bodyStyleFilter}";

        // Remove whitespace
        $url = preg_replace('/\s+/', '', $url);

        $response = Http::get($url);

        if ($response->failed()) {
            Log::error("CAP API failed", ['xml' => $response->body()]);
            $this->error("CAP API failed: " . $response->body());
            return Command::FAILURE;
        }

        // Get RAW XML
        $raw = $response->body();
        Log::info("CAP RAW XML", ['xml' => $raw]);

        // ------- CLEAN XML (Remove all namespaces and ns-prefixed attributes) -------
        $cleanXml = $raw;

        // Remove xmlns definitions
        $cleanXml = preg_replace('/xmlns[^=]*="[^"]*"/i', '', $cleanXml);

        // Remove namespace prefixes from tags <diffgr:...> => <...>
        $cleanXml = preg_replace('/(<\/?)[a-zA-Z0-9]+:/', '$1', $cleanXml);

        // Remove namespace prefixes from attributes msdata:rowOrder="1"
        $cleanXml = preg_replace('/\s+[a-zA-Z0-9]+:[a-zA-Z0-9]+="[^"]*"/', '', $cleanXml);


        // Parse into SimpleXML
        $xml = simplexml_load_string($cleanXml);

        if (!$xml) {
            Log::error("Failed to parse XML", ['xml' => $cleanXml]);
            $this->error("Failed to parse XML.");
            return Command::FAILURE;
        }

        // Convert to array
        $json = json_decode(json_encode($xml), true);
        // Log::info("CAP Parsed JSON", ['json' => $json]);

        // Extract manufacturers from the correct node
        $tables = $json['Returned_DataSet']['diffgram']['NewDataSet']['Table'] ?? [];

        $manufacturers = [];

        foreach ($tables as $row) {
            $manufacturers[] = [
                'code' => trim($row['CMan_Code'] ?? ''),
                'name' => trim($row['CMan_Name'] ?? ''),
            ];
        }

        // Log final manufacturers
        Log::info('CAP Manufacturers Parsed', ['manufacturers' => $manufacturers]);

        foreach ($manufacturers as $man) {
            \App\Models\Manufacturer::updateOrCreate(
                ['cap_id' => $man['code']],
                ['name' => $man['name']]
            );
        }
        // Output clean array
        $this->info('Manufacturers synced successfully');

        return Command::SUCCESS;
    }
}
