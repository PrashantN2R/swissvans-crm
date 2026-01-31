<?php

namespace Database\Seeders\Superadmin;

use App\Models\Derivative;
use App\Models\VanType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {

        # Delete the entire vehicles folder to ensure a fresh start
        $rootUploadPath = storage_path("app/public/uploads/vehicles");

        if (File::isDirectory($rootUploadPath)) {
            $this->command->warn("1️⃣ Cleaning Up Old Vehicle Image Directoty...");
            File::deleteDirectory($rootUploadPath);
        }

        # Re-create the root folder
        File::makeDirectory($rootUploadPath, 0755, true);

        # Get All Derivatives Columns: ['cap_id', 'manufacturer', 'capmod_id', 'model', 'derivative_id', 'name', 'introduced', 'model_ref_year']
        $derivatives        = Derivative::take(40)->get(['cap_id', 'manufacturer', 'capmod_id', 'model', 'derivative_id', 'name', 'introduced', 'model_ref_year']);

        # Get Random Van Type:
        $vanTypeName        = VanType::inRandomOrder()->first()?->name ?? 'Panel Van';

        # Total Count Derivatives:
        $total              = $derivatives->count();

        $bar                = $this->command->getOutput()->createProgressBar($total);
        $bar->start();

        $vehiclesToInsert       = [];
        $now                    = now();

        DB::beginTransaction();

        try {
            foreach ($derivatives as $key => $derivative) {
                $slug           = (string)mt_rand(10000000, 99999999) . (string)mt_rand(10000000, 99999999);
                $registration   = strtoupper(Str::random(3)) . rand(1000, 9999);
                $year           = $derivative->model_ref_year ? Carbon::parse($derivative->model_ref_year)->year : $now->year;
                $specs_html     = '<table style="width: 100%; border-collapse: collapse; font-family: sans-serif;">
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 8px; font-weight: bold; color: #666;">Manufacturer</td>
                            <td style="padding: 8px;">' . $derivative->manufacturer . '</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 8px; font-weight: bold; color: #666;">Model</td>
                            <td style="padding: 8px;">' . $derivative->model . '</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 8px; font-weight: bold; color: #666;">Variant</td>
                            <td style="padding: 8px;">' . $derivative->name . '</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; font-weight: bold; color: #666;">Introduced</td>
                            <td style="padding: 8px;">' . Carbon::parse($derivative->introduced)->format('d M Y') . '</td>
                        </tr>
                    </table>';
                $vehiclesToInsert[] = [
                    'user_id'                           => $key + 1,
                    'title'                             => "{$derivative->manufacturer} {$derivative->model} {$derivative->name}",
                    'slug'                              => $slug,
                    'registration'                      => $registration,
                    'vin'                               => strtoupper(Str::random(17)),
                    'model'                             => $derivative->model,
                    'year'                              => $year,
                    'short_description'                 => $specs_html,
                    'description'                       => $specs_html,
                    // Base Pricing
                    'price'                             => 40000,
                    'sale_price'                        => 38000,
                    'vat'                               => 20, // 20% of sale_price
                    'interest_rate'                     => 7.9,

                    // Business Lease Fields
                    'is_business_lease'                 => 1,
                    'business_lease_price'              => 450, // Standard monthly
                    'business_lease_discount_price'     => 415, // Discounted monthly

                    // Hire Purchase Fields
                    'is_hire_purchase'                  => 1,
                    'hire_purchase_price'               => 580, // Standard HP installment
                    'hire_purchase_discount_price'      => 540, // Discounted HP installment
                    'van_type'                          => $vanTypeName,
                    'hpi_mancode'                       => $derivative->cap_id,
                    'hpi_modcode'                       => $derivative->capmod_id,
                    'hpi_derivative'                    => $derivative->derivative_id,
                    'thumbnail'                         => 'thumbnail.webp',
                    'status'                            => 1,
                    'stock_status'                      => 'in_stock',
                    'meta_title'                        => "{$derivative->manufacturer} {$derivative->model} {$derivative->name}",
                    'meta_description'                  => "Buy the latest {{$derivative->manufacturer}} {$derivative->model} {{$derivative->name}} with flexible finance options, business lease and hire purchase deals. View full specifications, pricing, images, and availability. Fast approval, trusted dealer, nationwide delivery available.",
                    "meta_keywords"                     => "swiss vans, swissvans, vans for sale uk, used vans uk, new vans uk, commercial vans uk, business vans, van leasing uk, hire purchase vans, cheap vans uk, panel vans, electric vans uk, pickup trucks uk, fleet vans, company vans, van finance uk, small vans, large vans, automatic vans uk, diesel vans uk",
                    'created_at'                        => $now,
                    'updated_at'                        => $now,
                ];

                $bar->advance();
            }

            foreach (array_chunk($vehiclesToInsert, 500) as $chunk) {
                DB::table('vehicles')->insert($chunk);
            }

            $bar->finish();
            $this->command->newLine();

            // Task: Create ID-based folders and copy physical files
            $this->seedImagesAndFolders();

            DB::commit();
            $this->command->info("Seeding Complete!");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("\n Error: " . $e->getMessage());
        }
    }

    private function seedImagesAndFolders()
    {
        $vehicles = DB::table('vehicles')->get(['id']);
        $this->command->info("2️⃣ Creating Vehicle Image Directories and Copying Images...");
        $bar      = $this->command->getOutput()->createProgressBar($vehicles->count());

        $imagesToInsert = [];
        $now = now();

        $sourcePath = public_path('assets/seeders/');

        foreach ($vehicles as $vehicle) {
            $vehiclePath = storage_path("app/public/uploads/vehicles/{$vehicle->id}");
            $thumbDir = $vehiclePath . '/thumbnails';
            $imageDir = $vehiclePath . '/images';

            // Create specific directories
            File::makeDirectory($thumbDir, 0755, true);
            File::makeDirectory($imageDir, 0755, true);

            // Copy Thumbnail
            if (File::exists($sourcePath . 'thumbnail.webp')) {
                File::copy($sourcePath . 'thumbnail.webp', $thumbDir . '/thumbnail.webp');
            }

            // Copy Gallery Images (1-8)
            foreach (range(1, 8) as $index) {
                $fileName = "{$index}.webp";

                if (File::exists($sourcePath . $fileName)) {
                    File::copy($sourcePath . $fileName, $imageDir . '/' . $fileName);
                }

                $imagesToInsert[] = [
                    'vehicle_id' => $vehicle->id,
                    'attachment' => $fileName,
                    'extension'  => 'webp', // Updated from 'png' to match file type
                    'path'       => "uploads/vehicles/{$vehicle->id}/images/",
                    'sort_order' => $index,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            $bar->advance();
        }

        foreach (array_chunk($imagesToInsert, 1000) as $chunk) {
            DB::table('vehicle_images')->insert($chunk);
        }

        $bar->finish();
         $this->command->info("🚀 Vehicles (5173) seeded successfully.");

    }
}
