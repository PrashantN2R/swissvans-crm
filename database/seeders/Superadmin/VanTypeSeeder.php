<?php

namespace Database\Seeders\Superadmin;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class VanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $output = new ConsoleOutput();
        $vanTypes = [
            'Small Panel Vans',
            'Medium Panel Vans',
            'Large Panel Vans',
            'Crew Vans & Double Cabs',
            'Tippers & Dropsides',
            'Pickups',
            'Lutons',
            'Electric',
            'Hybrid',
            'Minibus',
        ];

        $progressBar = new ProgressBar($output, count($vanTypes));
        $progressBar->start();

        foreach ($vanTypes as $type) {
            DB::table('van_types')->insert([
                'name' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $progressBar->advance();
            // Small delay to make the progress bar visible for small datasets
            usleep(50000);
        }

        $progressBar->finish();
        $output->writeln("<info>🚀 Van Types (" . count($vanTypes) . ") seeded successfully. </info>");
    }
}
