<?php

namespace App\Console\Commands;

use App\Models\Model as VehicleModel;
use App\Models\Derivative;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncDerivativesForModelCommand extends Command
{
    protected $signature = 'app:sync-derivatives-for {capmod_id}';
    protected $description = 'Sync CAP derivatives for a specific model using its CAP MOD ID';

    public function handle()
    {
        $capmod_id = $this->argument('capmod_id');

        if (!$capmod_id) {
            $this->error("Model CAP MOD ID is required.");
            return Command::FAILURE;
        }

        // Fetch model details
        $model = VehicleModel::where('capmod_id', $capmod_id)->first();

        if (!$model) {
            $this->error("Model not found for CAP MOD ID: {$capmod_id}");
            return Command::FAILURE;
        }

        $this->info("Fetching derivatives for Model: {$model->name} ({$capmod_id})");

        $subscriberId = config('services.hpi.subscriber_id');
        $password     = config('services.hpi.password');
        $database     = config('services.hpi.database');

        // Correct CAP URL
        $url =
            "https://soap.cap.co.uk/Vehicles/CapVehicles.asmx/GetCapDer?" .
            "subscriberId={$subscriberId}" .
            "&password={$password}" .
            "&database={$database}" .
            "&modCode={$capmod_id}" .
            "&justCurrentDerivatives=True";

        $url = preg_replace('/\s+/', '', $url);

        $response = Http::withOptions(['verify' => false])->get($url);

        if ($response->failed()) {
            $this->error("API Request Failed:");
            $this->line($response->body());
            return Command::FAILURE;
        }

        $raw = $response->body();

        // Remove namespaces from XML
        $cleanXml = preg_replace('/xmlns[^=]*="[^"]*"/i', '', $raw);
        $cleanXml = preg_replace('/(<\/?)[a-zA-Z0-9]+:/', '$1', $cleanXml);
        $cleanXml = preg_replace('/\s+[a-zA-Z0-9]+:[a-zA-Z0-9]+="[^"]*"/', '', $cleanXml);

        $xml = simplexml_load_string($cleanXml);

        if (!$xml) {
            $this->error("Failed to parse XML for model: {$capmod_id}");
            Log::error("Derivative XML parse failed", ['xml' => $cleanXml]);
            return Command::FAILURE;
        }

        $json = json_decode(json_encode($xml), true);

        // Extract derivative items
        $tables = $json['Returned_DataSet']['diffgram']['NewDataSet']['Table'] ?? [];

        // Single-row → convert to array
        if (isset($tables['CDer_ID'])) {
            $tables = [$tables];
        }

        if (!$tables) {
            $this->warn("No derivatives found for model: {$capmod_id}");
            return Command::SUCCESS;
        }

        $this->info("Found " . count($tables) . " derivatives.");

        foreach ($tables as $row) {

            $derivativeId   = trim($row['CDer_ID'] ?? '');
            $derivativeName = trim($row['CDer_Name'] ?? '');

            if (!$derivativeId || !$derivativeName) continue;

            Derivative::updateOrCreate(
                ['derivative_id' => $derivativeId], // Unique CAP Derivative ID

                [
                    'capmod_id'      => $model->capmod_id,
                    'cap_id'         => $model->cap_id,
                    'manufacturer'   => $model->manufacturer,
                    'model'          => $model->name,
                    'name'           => $derivativeName,
                    'introduced'     => $row['CDer_Introduced'] ?? null,
                    'last_spec_date' => $row['LastSpecDate'] ?? null,
                    'model_ref_year' => trim($row['ModelYearRef'] ?? ''),
                ]
            );

            $this->info("✔ Saved Derivative: {$derivativeId} — {$derivativeName}");
        }

        $this->info("\nDerivatives synced successfully for model {$capmod_id}");
        return Command::SUCCESS;
    }
}
