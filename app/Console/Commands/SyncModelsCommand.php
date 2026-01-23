<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Manufacturer;
use App\Models\Model as VehicleModel;

class SyncModelsCommand extends Command
{
    protected $signature = 'app:sync-models';
    protected $description = 'Sync all CAP models for each manufacturer';

    public function handle()
    {
        $subscriberId = config('services.hpi.subscriber_id');
        $password     = config('services.hpi.password');
        $database     = config('services.hpi.database');

        $manufacturers = Manufacturer::all();

        if ($manufacturers->isEmpty()) {
            $this->error("No manufacturers found. Run app:sync-manufacturers first.");
            return Command::FAILURE;
        }

        foreach ($manufacturers as $man) {

            $manCap = trim($man->cap_id);
            if (!$manCap) continue;

            $this->info("Fetching models for manufacturer: {$man->name} (CAP: {$manCap})");

            // BUILD API URL
            $url =
                "https://soap.cap.co.uk/Vehicles/CapVehicles.asmx/GetCapMod?"
                . "subscriberId={$subscriberId}"
                . "&password={$password}"
                . "&database={$database}"
                . "&manRanCode={$manCap}"
                . "&manRanCodeIsMan=True"
                . "&justCurrentModels=True"
                . "&bodyStyleFilter=";

            $url = preg_replace('/\s+/', '', $url);

            $response = Http::withOptions(['verify' => false])->get($url);

            if ($response->failed()) {
                Log::error("CAP GetCapMod FAILED", [
                    'manufacturer' => $man->name,
                    'cap_id'       => $manCap,
                    'response'     => $response->body()
                ]);
                continue;
            }

            $raw = $response->body();

            // -------- FIXED NAMESPACE REMOVAL --------
            $cleanXml = preg_replace('/xmlns(:\w+)?="[^"]*"/', '', $raw);   // remove xmlns declarations
            $cleanXml = preg_replace('/(\w+):(\w+)/', '$2', $cleanXml);     // remove prefixes (diffgr, xs, msdata, etc.)

            $xml = simplexml_load_string($cleanXml, "SimpleXMLElement", LIBXML_NOCDATA);

            if (!$xml) {
                Log::error("XML PARSE FAILED", ['xml' => $cleanXml]);
                continue;
            }

            $json = json_decode(json_encode($xml), true);

            // -------- CORRECT JSON EXTRACTION PATH --------
            $tables = $json['Returned_DataSet']['diffgram']['NewDataSet']['Table'] ?? [];

            // Convert single record to array
            if (isset($tables['CMod_Code'])) {
                $tables = [$tables];
            }

            if (empty($tables)) {
                Log::warning("No models returned", ['manufacturer' => $man->name, 'cap_id' => $manCap]);
                continue;
            }

            $this->info("Found " . count($tables) . " models.");

            foreach ($tables as $row) {

                $modelCode = trim($row['CMod_Code'] ?? '');
                $modelName = trim($row['CMod_Name'] ?? '');

                if (!$modelCode || !$modelName) continue;

                // -------- SAVING FIXED --------
                VehicleModel::updateOrCreate(
                    [
                        'capmod_id' => $modelCode,
                    ],
                    [
                        'cap_id'           => $manCap,        // ✔ correct manufacturer CAP ID
                        'manufacturer'     => $man->name,
                        'name'             => $modelName,
                        'introduced'       => $row['CMod_Introduced'] ?? null,
                        'discount_percent' => 0,
                        'profit_percent'   => 0,
                        'profit'           => 0,
                    ]
                );

                $this->info("✔ Saved: {$modelCode} — {$modelName}");
            }
        }

        $this->info("All models synced successfully.");
        return Command::SUCCESS;
    }
}
