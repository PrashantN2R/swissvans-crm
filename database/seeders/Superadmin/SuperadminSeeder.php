<?php

namespace Database\Seeders\Superadmin;

use App\Models\Superadmin;
use App\Models\User;
use Faker\Generator;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker                      = app(Generator::class);
        $output                     = new ConsoleOutput();

        $staffUsers                 = [
            [
                'role'              => 'Administrator',
                'firstname'         => 'Nurul',
                'lastname'          => 'Hasan',
                'email'             => 'admin@admin.com',
                'dialcode'          => '+91',
                'phone'             => '9968584843',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'gender'            => 'Male',
                'address'           => 'C-6, Sector 7',
                'city'              => 'Noida',
                'zipcode'           => '201301',
                'state'             => 'Uttar Pradesh',
                'iso2'              => 'in',
                'remember_token'    => Str::random(10),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'role'              => 'Manager',
                'firstname'         => 'Mohd',
                'lastname'          => 'Danish',
                'email'             => 'manager@admin.com',
                'dialcode'          => '+91',
                'phone'             => '7065794843',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'gender'            => 'Male',
                'address'           => 'House No.1, Shree nagar Extension, Ashok Vihar',
                'city'              => 'Delhi',
                'zipcode'           => '110009',
                'state'             => 'New Delhi',
                'iso2'              => 'in',
                'remember_token'    => Str::random(10),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'role'              => 'Sales Executive',
                'firstname'         => 'Sohrab',
                'lastname'          => 'Khan',
                'email'             => 'sales@admin.com',
                'dialcode'          => '+91',
                'phone'             => '9793920919',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'gender'            => 'Male',
                'address'           => 'C-6, Sector 7',
                'city'              => 'Noida',
                'zipcode'           => '201301',
                'state'             => 'Uttar Pradesh',
                'iso2'              => 'in',
                'remember_token'    => Str::random(10),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ];

        $progressBar                = new ProgressBar($output, count($staffUsers));
        $progressBar->start();

        foreach ($staffUsers as $staff) {

            $user                   = Superadmin::create([
                'firstname'         => $staff['firstname'],
                'lastname'          => $staff['lastname'],
                'email'             => $staff['email'],
                'dialcode'          => $staff['dialcode'],
                'phone'             => $staff['phone'],
                'email_verified_at' => $staff['email_verified_at'],
                'password'          => $staff['password'],
                'gender'            => $staff['gender'],
                'address'           => $staff['address'],
                'city'              => $staff['city'],
                'zipcode'           => $staff['zipcode'],
                'state'             => $staff['state'],
                'iso2'              => $staff['iso2'],
                'remember_token'    => $staff['remember_token'],
                'created_at'        => $staff['created_at'],
                'updated_at'        => $staff['updated_at'],
            ]);

            switch ($staff['role']) {
                case 'Administrator':
                    $user->assignRole('Administrator');
                    break;
                case 'Manager':
                    $user->assignRole('Manager');
                    break;
                case 'Sales Executive':
                    $user->assignRole('Sales Executive');
                    break;
            }
            $progressBar->advance();
            usleep(100000);
        }

        $progressBar->finish();
        $output->writeln("<info> Superadmin (" . count($staffUsers) . ") seeded and roles assigned to superadmins successfully. </info>");
    }
}
