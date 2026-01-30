<?php

namespace Database\Seeders\Superadmin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles               = [
            [
                'id'         => 1,
                'name'       => 'Administrator',
                'guard_name' => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 2,
                'name'       => 'Manager',
                'guard_name' => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 3,
                'name'       => 'Sales Executive',
                'guard_name' => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $output                 = new ConsoleOutput();
        $progressBar            = new ProgressBar($output, count($roles));
        $progressBar->start();

        foreach ($roles as $role) {
            Role::create($role);
            $progressBar->advance();
            usleep(100000);
        }

        $progressBar->finish();
        $output->writeln("<info>🚀 Roles (" . count($roles) . ") seeded successfully. </info>");
    }
}
