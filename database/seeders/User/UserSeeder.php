<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $output                     = new ConsoleOutput();
        $jsonPath                   = database_path('data/user/users.json');

        if (!File::exists($jsonPath)) {
            $output->writeln("<error>❌ JSON file not found at: {$jsonPath}</error>");
            return;
        }

        $jsonData                   = File::get($jsonPath);
        $data                       = json_decode($jsonData, true);

        if (!isset($data['users']) || !is_array($data['users'])) {
            $output->writeln("<error>❌ Invalid users structure in JSON.</error>");
            return;
        }

        $users                      = $data['users'];
        $progressBar                = new ProgressBar($output, count($users));
        $progressBar->start();

        $hashedPassword             = Hash::make('password');
        $insertData                 = [];

        foreach ($users as $row) {
            $insertData[]           = [
                'slug'              => Str::slug($row['firstname'] . '-' . $row['lastname']),
                'firstname'         => $row['firstname'],
                'lastname'          => $row['lastname'],
                'email'             => $row['email'],
                'dialcode'          => $row['dialcode'],
                'phone'             => $row['phone'],
                'email_verified_at' => now(),
                'password'          => $hashedPassword,
                'gender'            => $row['gender'],
                'address'           => $row['address'],
                'city'              => $row['city'],
                'zipcode'           => $row['zipcode'],
                'state'             => $row['state'],
                'iso2'              => $row['iso2'],
                'remember_token'    => Str::random(10),
                'created_at'        => now(),
                'updated_at'        => now(),
            ];

            $progressBar->advance();
        }

        User::insert($insertData);

        $progressBar->finish();
        $output->writeln("<info> Users (" . count($users) . ") seeded successfully. </info>");
    }
}
