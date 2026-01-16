<?php

namespace Database\Seeders\Superadmin;

use App\Models\Lead;
use App\Models\Quotation;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuotationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leads = Lead::whereIn('status', ['Quoted', 'Negotiation', 'Won', 'Lost'])->get();

        $items = [
            [
                'item'        => 'Stage Setup (20x30 ft)',
                'unit'        => 'sqft',
                'rate'        => 150.00,
                'quantity'    => 600, // 20x30
                'amount'      => 150.00 * 600,
            ],
            [
                'item'        => 'LED Wall (10x8 ft)',
                'unit'        => 'sqft',
                'rate'        => 450.00,
                'quantity'    => 80,
                'amount'      => 450.00 * 80,
            ],
            [
                'item'        => 'Sound System (Line Array)',
                'unit'        => 'package',
                'rate'        => 25000.00,
                'quantity'    => 1,
                'amount'      => 25000.00,
            ],
            [
                'item'        => 'Decor & Floral Arrangement',
                'unit'        => 'package',
                'rate'        => 15000.00,
                'quantity'    => 1,
                'amount'      => 15000.00,
            ],
            [
                'item'        => 'Lighting (Par Cans + Moving Heads)',
                'unit'        => 'set',
                'rate'        => 12000.00,
                'quantity'    => 1,
                'amount'      => 12000.00,
            ],
            [
                'item'        => 'Chair & Table Setup (500 Pax)',
                'unit'        => 'pcs',
                'rate'        => 120.00,
                'quantity'    => 500,
                'amount'      => 120.00 * 500,
            ],
            [
                'item'        => 'Catering (Buffet – 500 Pax)',
                'unit'        => 'plate',
                'rate'        => 650.00,
                'quantity'    => 500,
                'amount'      => 650.00 * 500,
            ]
        ];

        foreach ($leads as $key => $lead) {

            switch ($lead->status) {
                case 'Quoted':
                    $status = "Sent";
                    break;
                case 'Negotiation':
                    $status = "Pending";
                    break;
                case 'Won':
                    $status = "Accepted";
                    break;
                default:
                    $status = "Declined";
                    break;
            }
            $quotation          = Quotation::create([
                'lead_id'       => $lead->id,
                'quote_date'    => Carbon::now()->format('Y-m-d'),
                'expiry_date'   => Carbon::now()->addDay(1)->format('Y-m-d'),
                'created_by'    => 'Manager',
                'created_by_id' => 2,
                'assigned_to'   => $lead->assigned_to,
                'status'        => $status,
                'note'          => 'No Note Added.'
            ]);

            foreach ($items as $key => $item) {
                DB::table('quotation_items')->insert([
                    'quotation_id'  => $quotation->id,
                    'item'          => $item['item'],
                    'unit'          => $item['unit'],
                    'rate'          => $item['rate'],
                    'quantity'      => $item['quantity'],
                    'amount'        => $item['amount'],
                    'created_at'    => now(),
                    'updated_at'    => now()
                ]);
            }
        }
    }
}
