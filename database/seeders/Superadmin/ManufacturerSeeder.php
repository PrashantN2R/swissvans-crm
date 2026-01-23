<?php

namespace Database\Seeders\Superadmin;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManufacturerSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('manufacturers')->delete();

        DB::table('manufacturers')->insert(array(
            0 =>
            array(
                'id' => 82,
                'cap_id' => '59029',
                'name' => 'B-ON',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            1 =>
            array(
                'id' => 83,
                'cap_id' => '59642',
                'name' => 'BYD',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            2 =>
            array(
                'id' => 84,
                'cap_id' => '41',
                'name' => 'CITROEN',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            3 =>
            array(
                'id' => 85,
                'cap_id' => '128',
                'name' => 'DACIA',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            4 =>
            array(
                'id' => 86,
                'cap_id' => '64136',
                'name' => 'FARIZON',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            5 =>
            array(
                'id' => 87,
                'cap_id' => '175',
                'name' => 'FIAT',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            6 =>
            array(
                'id' => 88,
                'cap_id' => '296',
                'name' => 'FORD',
                'delivery_charge' => '1500.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            7 =>
            array(
                'id' => 89,
                'cap_id' => '64856',
                'name' => 'GWM',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            8 =>
            array(
                'id' => 90,
                'cap_id' => '57548',
                'name' => 'INEOS',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            9 =>
            array(
                'id' => 91,
                'cap_id' => '549',
                'name' => 'ISUZU',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            10 =>
            array(
                'id' => 92,
                'cap_id' => '555',
                'name' => 'ISUZU TRUCK',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            11 =>
            array(
                'id' => 93,
                'cap_id' => '561',
                'name' => 'IVECO',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            12 =>
            array(
                'id' => 94,
                'cap_id' => '60419',
                'name' => 'KGM',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            13 =>
            array(
                'id' => 95,
                'cap_id' => '607',
                'name' => 'KIA',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            14 =>
            array(
                'id' => 96,
                'cap_id' => '616',
                'name' => 'LAND ROVER',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            15 =>
            array(
                'id' => 97,
                'cap_id' => '49845',
                'name' => 'LEVC',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            16 =>
            array(
                'id' => 98,
                'cap_id' => '43043',
                'name' => 'MAN',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            17 =>
            array(
                'id' => 99,
                'cap_id' => '49852',
                'name' => 'MAXUS',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            18 =>
            array(
                'id' => 100,
                'cap_id' => '880',
                'name' => 'MERCEDES-BENZ',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            19 =>
            array(
                'id' => 101,
                'cap_id' => '1042',
                'name' => 'NISSAN',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            20 =>
            array(
                'id' => 102,
                'cap_id' => '59343',
                'name' => 'OHM',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            21 =>
            array(
                'id' => 103,
                'cap_id' => '1083',
                'name' => 'PEUGEOT',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            22 =>
            array(
                'id' => 104,
                'cap_id' => '1268',
                'name' => 'RENAULT',
                'delivery_charge' => '1000.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            23 =>
            array(
                'id' => 105,
                'cap_id' => '3271',
                'name' => 'RENAULT TRUCKS UK',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            24 =>
            array(
                'id' => 106,
                'cap_id' => '1436',
                'name' => 'TOYOTA',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            25 =>
            array(
                'id' => 107,
                'cap_id' => '1477',
                'name' => 'VAUXHALL',
                'delivery_charge' => '0.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            26 =>
            array(
                'id' => 108,
                'cap_id' => '1567',
                'name' => 'VOLKSWAGEN',
                'delivery_charge' => '1000.00',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));
    }
}
