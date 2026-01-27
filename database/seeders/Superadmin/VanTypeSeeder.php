<?php

namespace Database\Seeders\Superadmin;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        foreach ($vanTypes as $type) {
            DB::table('van_types')->insert([
                'name' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
