<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data to avoid duplicates during testing
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Vehicle::truncate();
        VehicleImage::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $title = $faker->company . ' ' . $faker->word . ' Edition';

            // 1. Create the Vehicle
            $vehicle = Vehicle::create([
                'user_id'           => 1, // Assumes a SuperAdmin exists with ID 1
                'title'             => $title,
                'slug'              => Str::slug($title) . '-' . time() . $i,
                'registration'      => strtoupper($faker->bothify('??## ???')),
                'vin'               => strtoupper($faker->bothify('VNVN###########')),
                'model'             => $faker->word,
                'year'              => $faker->year(),
                'short_description' => $faker->sentence(),
                'description'       => $faker->paragraphs(3, true),

                // Financials
                'price'             => $faker->randomFloat(2, 20000, 50000),
                'sale_price'        => $faker->randomFloat(2, 18000, 19999),
                'vat'               => 20.00,
                'interest_rate'     => 5.9,

                // Leasing Options
                'is_business_lease' => 1,
                'business_lease_price'          => 299.99,
                'business_lease_discount_price' => 249.99,
                'is_hire_purchase'              => 1,
                'hire_purchase_price'           => 350.00,
                'hire_purchase_discount_price'  => 310.00,

                // HPI Technical
                'van_type'          => $faker->randomElement(['Panel Van', 'Pickup', 'Tipper']),
                'hpi_mancode'       => 'MAN' . $faker->numberBetween(100, 999),
                'hpi_modcode'       => 'MOD' . $faker->numberBetween(100, 999),
                'hpi_derivative'    => 'DERIV' . $faker->numberBetween(100, 999),

                // UI & SEO
                'thumbnail'         => 'uploads/vehicles/thumbnails/seed_thumb.jpg',
                'meta_title'        => $title . ' | Buy Now',
                'meta_description'  => $faker->sentence(),
                'meta_keywords'     => 'van, vehicle, leasing, ' . $title,
                'status'            => 1,
                'stock_status'      => 'in_stock',
            ]);

            // 2. Create 3 Dummy Gallery Images per Vehicle
            for ($j = 1; $j <= 3; $j++) {
                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'attachment' => "seed_image_{$j}.jpg",
                    'extension'  => 'jpg',
                    'path'       => "uploads/vehicles/{$vehicle->id}/images/seed_image_{$j}.jpg",
                    'alt'        => $title . ' Gallery ' . $j,
                    'sort_order' => $j,
                ]);
            }
        }
    }
}
