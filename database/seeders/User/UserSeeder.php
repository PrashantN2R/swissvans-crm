<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $output = new ConsoleOutput();
        $faker = Faker::create('en_GB'); // Using UK locale for realistic data
        $totalUsers = 5173;

        $progressBar = new ProgressBar($output, $totalUsers);
        $progressBar->start();

        $hashedPassword = Hash::make('password');
        $chunkSize = 500; // Batching inserts for performance
        $data = [];

        for ($i = 1; $i <= $totalUsers; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            $data[] = [
                'name'              => $firstName . ' ' . $lastName,
                'slug'              => Str::slug($firstName . '-' . $lastName . '-' . Str::random(5)),
                'email'             => $faker->unique()->safeEmail,
                'dialcode'          => '44',
                'phone'             => $faker->randomElement([ $faker->numerify('7#########'),  $faker->numerify('9#########',  $faker->numerify('8#########'),  $faker->numerify('6#########'))]),
                'email_verified_at' => now(),
                'password'          => $hashedPassword,
                'gender'            => $faker->randomElement(['Male', 'Female', 'Other']),
                'address'           => $faker->streetAddress,
                'city'              => $faker->city,
                'zipcode'           => $faker->postcode,
                'state'             => $faker->county,
                'iso2'              => 'GB',
                'remember_token'    => Str::random(10),
                'created_at'        => now(),
                'updated_at'        => now(),
            ];

            // When chunk size is reached, insert and clear array
            if ($i % $chunkSize === 0) {
                User::insert($data);
                $data = [];
                $progressBar->advance($chunkSize);
            }
        }

        // Insert remaining records
        if (!empty($data)) {
            User::insert($data);
            $progressBar->advance(count($data));
        }

        $progressBar->finish();
        $output->writeln("<info>🚀 Users {$totalUsers} seeded successfully.</info>");
    }
}
