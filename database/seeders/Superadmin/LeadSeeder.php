<?php

namespace Database\Seeders\Superadmin;

use App\Models\Lead;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $output                        = new ConsoleOutput();
        $jsonPath                      = database_path('data/superadmin/leads.json');

        if (!File::exists($jsonPath)) {
            $output->writeln("<error>❌ JSON file not found at: {$jsonPath}</error>");
            return;
        }

        $jsonData                      = File::get($jsonPath);
        $data                          = json_decode($jsonData, true);

        if (!isset($data['leads']) || !is_array($data['leads'])) {
            $output->writeln("<error>❌ Invalid leads structure in JSON.</error>");
            return;
        }

        $leads                         = $data['leads'];
        $progressBar                   = new ProgressBar($output, count($leads));
        $progressBar->start();

        foreach ($leads as $row) {
            $lead                       =  Lead::create([
                'name'                  => $row['name'],
                'designation'           => $row['designation'],
                'company'               => $row['company'],
                'email'                 => $row['email'],
                'phone'                 => $row['phone'],
                'budget'                => $row['budget'],
                'event_type'            => $row['event_type'],
                'event_date'            => $row['event_date'],
                'source'                => $row['source'],
                'description'           => $row['description'],
                'location'              => $row['location'],
                'meta'                  => null,
                'status'                => $row['status'],
                'created_by'            => 2,
                'assigned_to'           => 3,
            ]);
            $progressBar->advance();
        }

        $progressBar->finish();
        $output->writeln("<info>🚀 Leads (" . count($leads) . ") seeded successfully. </info>");
    }
}
