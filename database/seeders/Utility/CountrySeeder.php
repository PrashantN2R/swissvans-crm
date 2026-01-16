<?php

namespace Database\Seeders\Utility;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Country;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $output                        = new ConsoleOutput();
        $jsonPath                      = database_path('data/utility/countries.json');

        if (!File::exists($jsonPath)) {
            $output->writeln("<error>❌ JSON file not found at: {$jsonPath}</error>");
            return;
        }

        $jsonData                      = File::get($jsonPath);
        $data                          = json_decode($jsonData, true);

        if (!isset($data['countries']) || !is_array($data['countries'])) {
            $output->writeln("<error>❌ Invalid countries structure in JSON.</error>");
            return;
        }

        $countries                     = $data['countries'];
        $progressBar                   = new ProgressBar($output, count($countries));
        $progressBar->start();

        foreach ($countries as $row) {
            $country         = new Country();
            $country->code   = $row['code'];
            $country->name   = $row['name'];
            $country->save();

            $progressBar->advance();
        }

        $progressBar->finish();
        $output->writeln("<info> Countries (" . count($countries) . ") seeded successfully. </info>");
    }
}
