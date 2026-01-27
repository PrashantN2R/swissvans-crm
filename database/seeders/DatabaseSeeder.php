<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use App\Models\User;
use Database\Seeders\Superadmin\DerivativeSeeder;
use Database\Seeders\Superadmin\LeadSeeder;
use Database\Seeders\Superadmin\ManufacturerSeeder;
use Database\Seeders\Superadmin\ModelSeeder;
use Database\Seeders\Superadmin\PermissionSeeder;
use Database\Seeders\Superadmin\QuotationSeeder;
use Database\Seeders\Superadmin\RoleSeeder;
use Database\Seeders\Superadmin\SuperadminSeeder;
use Database\Seeders\Superadmin\TaskSeeder;
use Database\Seeders\Superadmin\VanTypeSeeder;
use Database\Seeders\Superadmin\VehicleSeeder;
use Database\Seeders\User\UserSeeder;
use Database\Seeders\Utility\CountrySeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   $this->call(SuperadminSeeder::class);
        $this->call(LeadSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(QuotationSeeder::class);
        $this->call(ManufacturerSeeder::class);
        $this->call(ModelSeeder::class);
        $this->call(DerivativeSeeder::class);
        $this->call(VanTypeSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);


    }
}
