<?php

namespace App\Console\Commands;

use App\Models\Model as VehicleModel;
use App\Models\Derivative;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncDerivativesCommand extends Command
{
    protected $signature = 'app:sync-derivatives';
    protected $description = 'Sync all CAP derivatives for every model';

    public function handle()
    {
        $subscriberId = config('services.hpi.subscriber_id');
        $password     = config('services.hpi.password');
        $database     = config('services.hpi.database');

        $models = VehicleModel::whereNotNull('capmod_id')->get();

        if ($models->isEmpty()) {
            $this->error("No models found. Run sync-models first.");
            return Command::FAILURE;
        }

        $this->info("Syncing derivatives for " . $models->count() . " models...");

        foreach ($models as $model) {

            $capmod = trim($model->capmod_id);

            if (!$capmod) continue;

            $this->info("\nFetching derivatives for Model {$capmod} — {$model->name}");

            $url =
                "https://soap.cap.co.uk/Vehicles/CapVehicles.asmx/GetCapDer?" .
                "subscriberId={$subscriberId}" .
                "&password={$password}" .
                "&database={$database}" .
                "&modCode={$capmod}" .
                "&justCurrentDerivatives=True";

            $url = preg_replace('/\s+/', '', $url);

            $response = Http::withOptions(['verify' => false])->get($url);

            if ($response->failed()) {
                $this->error("Derivative API failed for model {$capmod}");
                continue;
            }

            $raw = $response->body();

            // CLEAN XML (remove namespaces)
            $cleanXml = preg_replace('/xmlns[^=]*="[^"]*"/i', '', $raw);
            $cleanXml = preg_replace('/(<\/?)[a-zA-Z0-9]+:/', '$1', $cleanXml);
            $cleanXml = preg_replace('/\s+[a-zA-Z0-9]+:[a-zA-Z0-9]+="[^"]*"/', '', $cleanXml);

            $xml = simplexml_load_string($cleanXml);

            if (!$xml) {
                $this->error("Failed to parse XML for model {$capmod}");
                continue;
            }

            $json = json_decode(json_encode($xml), true);

            $tables = $json['Returned_DataSet']['diffgram']['NewDataSet']['Table'] ?? [];

            if (isset($tables['CDer_ID'])) {
                $tables = [$tables];
            }

            if (!$tables) {
                $this->warn("No derivatives found for model {$capmod}");
                continue;
            }

            $this->info("Found " . count($tables) . " derivatives.");

            foreach ($tables as $row) {

                $derivId   = trim($row['CDer_ID'] ?? '');
                $derivName = trim($row['CDer_Name'] ?? '');

                if (!$derivId || !$derivName) continue;

                Derivative::updateOrCreate(
                    ['derivative_id' => $derivId],
                    [
                        'capmod_id'       => $capmod,
                        'cap_id'          => $model->cap_id,
                        'manufacturer'    => $model->manufacturer,
                        'model'           => $model->name,
                        'name'            => $derivName,
                        'introduced'      => $row['CDer_Introduced'] ?? null,
                        'last_spec_date'  => $row['LastSpecDate'] ?? null,
                        'model_ref_year'  => trim($row['ModelYearRef'] ?? ''),
                    ]
                );

                $this->info("✔ Saved Derivative: {$derivId} — {$derivName}");
            }
        }

        $this->info("\nAll derivatives synced successfully.");
        return Command::SUCCESS;
    }
}
