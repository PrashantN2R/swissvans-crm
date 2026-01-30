<?php

namespace Database\Seeders\Superadmin;

use App\Models\Deal;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Superadmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class DealSeeder extends Seeder
{
    public function run(): void
    {
        $output = new ConsoleOutput();
        $faker = Faker::create('en_GB');

        $vehicles = Vehicle::all();
        $adminIds = Superadmin::pluck('id')->toArray();

        if ($vehicles->isEmpty()) {
            $output->writeln("<error>❌ No vehicles found. Seed vehicles first!</error>");
            return;
        }

        $progressBar = new ProgressBar($output, $vehicles->count());
        $progressBar->start();

        foreach ($vehicles as $vehicle) {
            // Exclude owner from being the buyer
            $potentialBuyers = User::where('id', '!=', $vehicle->user_id)->pluck('id')->toArray();
            if (empty($potentialBuyers)) continue;

            // --- Financial Logic Based on Reference ---
            $basePrice = $faker->randomFloat(2, 35000, 55000); // Reference: 40,000
            $discount = $faker->randomFloat(2, 1000, 3000);   // Reference: 2,000 discount
            $salePrice = $basePrice - $discount;
            $vat = $salePrice * 0.20;                          // 20% VAT

            // Randomize Finance Path
            $isLease = $faker->boolean(50);
            $isHP = !$isLease;
            $status = $faker->randomElement(['Draft', 'Pending', 'Completed']);
            Deal::create([
                'deal_number'        => 'DEAL-' . strtoupper(Str::random(8)),
                'user_id'            => $faker->randomElement($potentialBuyers),
                'vehicle_id'         => $vehicle->id,
                'salesperson_id'     => $faker->randomElement($adminIds),

                // Core Pricing
                'price'              => $basePrice,
                'sale_price'         => $salePrice,
                'vat'                => $vat,
                'interest_rate'      => 7.9, // Fixed as per reference

                // Business Lease Fields
                'is_business_lease'             => 1,
                'business_lease_price'          => $faker->numberBetween(430, 480),
                'business_lease_discount_price' => $faker->numberBetween(400, 425),

                // Hire Purchase Fields
                'is_hire_purchase'              => 1,
                'hire_purchase_price'           => $faker->numberBetween(560, 600),
                'hire_purchase_discount_price'  => $faker->numberBetween(520, 550),

                'type'               => $isLease ? 'Lease' : 'Sale',
                'status'             => $status,
                'is_immutable'       =>  $status == "Completed" ? 1 : 0, // Set to 1 if you want them locked by default
                'created_at'         => now()->subDays($vehicle->id)->addHours(rand(1, 23))->addMinutes(rand(1, 59)),
            ]);

            $progressBar->advance();
        }

        $progressBar->finish();
        $output->writeln("<info>🚀 Deals (5173) seeded successfully.</info>");
    }
}
