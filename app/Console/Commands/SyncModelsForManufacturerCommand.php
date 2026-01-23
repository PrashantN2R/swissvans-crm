<?php

namespace App\Console\Commands;

use App\Models\Manufacturer;
use App\Models\Model;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncModelsForManufacturerCommand extends Command
{
    protected $signature = 'app:sync-models-for {cap_id}';
    protected $description = 'Sync CAP models for a specific manufacturer using its CAP ID';

    public function handle()
    {
        $capId = $this->argument('cap_id');

        $manufacturer = Manufacturer::where('cap_id', $capId)->first();
        if (!$manufacturer) {
            $this->error("Manufacturer not found for CAP ID {$capId}");
            return Command::FAILURE;
        }

        $subscriberId = config('services.hpi.subscriber_id');
        $password     = config('services.hpi.password');
        $database     = config('services.hpi.database');

        $url =
            "https://soap.cap.co.uk/Vehicles/CapVehicles.asmx/GetCapMod?"
            . "subscriberId={$subscriberId}"
            . "&password={$password}"
            . "&database={$database}"
            . "&manRanCode={$capId}"
            . "&manRanCodeIsMan=True"
            . "&justCurrentModels=True"
            . "&bodyStyleFilter=";

        $url = preg_replace('/\s+/', '', $url);

        $response = Http::withOptions(['verify' => false])->get($url);

        if ($response->failed()) {
            $this->error("API failed: " . $response->body());
            return Command::FAILURE;
        }

        $raw = $response->body();

        // --- FIXED CLEANUP ---
        $cleanXml = preg_replace('/xmlns(:\w+)?="[^"]*"/', '', $raw); // remove only xmlns
        $cleanXml = preg_replace('/(\w+):(\w+)/', '$2', $cleanXml);   // remove prefixes

        $xml = simplexml_load_string($cleanXml, "SimpleXMLElement", LIBXML_NOCDATA);

        if (!$xml) {
            Log::error("XML Parse Failed", ['xml' => $cleanXml]);
            $this->error("Failed to parse XML");
            return Command::FAILURE;
        }

        $json = json_decode(json_encode($xml), true);

        // DEBUG: Show entire structure for verification
        Log::info('JSON STRUCTURE', ['json' => $json]);

        // --- FIX 2: Correct extraction path ---
        $tables = $json['Returned_DataSet']['diffgram']['NewDataSet']['Table'] ?? [];

        if (isset($tables['CMod_Code'])) {
            $tables = [$tables];
        }

        if (empty($tables)) {
            $this->warn("No models found for CAP ID {$capId}");
            return Command::SUCCESS;
        }

        $this->info("Found " . count($tables) . " models.");

        foreach ($tables as $row) {

            $modelCode  = $row['CMod_Code'] ?? null;
            $modelName  = trim($row['CMod_Name'] ?? '');

            if (!$modelCode || !$modelName) continue;

            Model::updateOrCreate(
                ['capmod_id' => $modelCode],
                [
                    'cap_id'        => $capId,
                    'name'          => $modelName,
                    'introduced'    => $row['CMod_Introduced'] ?? null,
                    'discontinued'  => $row['CMod_Discontinued'] ?? null,
                    'manufacturer'  => $manufacturer->name,
                ]
            );

            $this->info("✔ {$modelCode} — {$modelName}");
        }

        return Command::SUCCESS;
    }
}
