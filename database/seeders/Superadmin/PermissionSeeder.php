<?php

namespace Database\Seeders\Superadmin;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $output                        = new ConsoleOutput();
        $jsonPath                      = database_path('data/superadmin/permissions.json');

        if (!File::exists($jsonPath)) {
            $output->writeln("<error>❌ JSON file not found at: {$jsonPath}</error>");
            return;
        }

        $jsonData                      = File::get($jsonPath);
        $data                          = json_decode($jsonData, true);

        if (!isset($data['permissions']) || !is_array($data['permissions'])) {
            $output->writeln("<error>❌ Invalid permissions structure in JSON.</error>");
            return;
        }

        $permissions                   = $data['permissions'];
        $progressBar                   = new ProgressBar($output, count($permissions));
        $progressBar->start();

        foreach ($permissions as $row) {
            $perm                      =  Permission::create(['name' => $row['name'], 'guard_name' => 'superadmin']);

            foreach ($row['roles'] as $roleName) {
                $role                  = Role::where('name', $roleName)->first();
                $role->givePermissionTo($perm);
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $output->writeln("<info> Permissions (" . count($permissions) . ") seeded and permission given to roles successfully. </info>");
    }
}
