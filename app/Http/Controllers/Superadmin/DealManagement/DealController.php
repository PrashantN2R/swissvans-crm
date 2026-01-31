<?php

namespace App\Http\Controllers\Superadmin\DealManagement;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Superadmin;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DealController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:superadmin');
    }

    /**
     * Check if the deal is in a state where it can no longer be modified.
     * * @param  \App\Models\Deal  $deal
     * @return bool
     */
    protected function checkImmutable($deal)
    {
        // Common logic: If a deal is 'completed', 'cancelled', or 'sold',
        // it should probably be immutable (unchangeable).
        $immutableStatuses = ['completed', 'sold', 'cancelled'];

        if (in_array(strtolower($deal->status), $immutableStatuses)) {
            return true;
        }

        return false;
    }

    public function index(Request $request)
    {
        $deals = Deal::with(['vehicle', 'user', 'salesperson'])
            // Filter by Deal Table Columns
            ->when($request->deal_number, fn($q) => $q->where('deal_number', 'LIKE', "%{$request->deal_number}%"))
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->salesperson_id, fn($q) => $q->where('salesperson_id', $request->salesperson_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->type, fn($q) => $q->where('type', $request->type))

            // Finance Path Logic
            ->when($request->finance_path == 'business', fn($q) => $q->where('is_business_lease', 1))
            ->when($request->finance_path == 'hp', fn($q) => $q->where('is_hire_purchase', 1))

            // Date Range
            ->when($request->date_from, fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->whereDate('created_at', '<=', $request->date_to))

            // Reach into Vehicle Relationship for Vehicle-specific filters
            ->whereHas('vehicle', function ($query) use ($request) {
                $query->when($request->registration, fn($q) => $q->where('registration', 'LIKE', "%{$request->registration}%"))
                    ->when($request->vin, fn($q) => $q->where('vin', 'LIKE', "%{$request->vin}%"))
                    ->when($request->make, fn($q) => $q->where('hpi_mancode', $request->make))
                    ->when($request->model, fn($q) => $q->where('hpi_modcode', $request->model))
                    ->when($request->derivative, fn($q) => $q->where('derivative', 'LIKE', "%{$request->derivative}%"));
            })
            ->orderBy('id', 'desc')
            ->paginate(100);

        // Data for Filter Dropdowns
        $customers      = User::orderBy('name')->get();
        $salespeople    = Superadmin::orderBy('firstname')->get(); // Adjust if you have a specific role
        $manufacturers  = Manufacturer::orderBy('name')->get();

        // Dependent model dropdown logic
        $fillmodels = $request->make
            ? Model::where('cap_id', $request->make)->orderBy('name')->get()
            : collect([]);

        return view('superadmin.deal-management.list', compact(
            'deals',
            'customers',
            'salespeople',
            'manufacturers',
            'fillmodels'
        ));
    }

    public function create()
    {
        $customers      = User::orderBy('name')->get();
        $salespeople    = Superadmin::orderBy('firstname')->get();
        $statuses       = ['Draft', 'Pending', 'Completed', 'Cancelled'];
        $vehicles       = Vehicle::get(['id', 'registration', 'model']);
        return view('superadmin.deal-management.create', compact('customers', 'salespeople', 'statuses', 'vehicles'));
    }


    public function store(Request $request)
    {
        $rules = [
            'customer'                              => 'required|exists:users,id',
            'vehicle'                               => 'required|exists:vehicles,id',
            'salesperson'                           => 'nullable|exists:superadmins,id',
            'type'                                  => 'required|in:Sale,Lease',
            'status'                                => 'required|string',
            'commission_amount'                     => 'nullable|numeric|min:0',
            'price'                                 => 'required|numeric|min:0',
            'sale_price'                            => 'required|numeric|min:0',
            'vat'                                   => 'required|numeric|min:0',
            'interest_rate'                         => 'required|numeric|min:0',
            'is_business_lease'                     => 'required|boolean',
            'business_lease_price'                  => 'nullable|numeric|min:0',
            'business_lease_discount_price'         => 'nullable|numeric|min:0',
            'is_hire_purchase'                      => 'required|boolean',
            'hire_purchase_price'                   => 'nullable|numeric|min:0',
            'hire_purchase_discount_price'          => 'nullable|numeric|min:0',
        ];

        $messages = [
            'customer.required'                     => 'Please select a customer.',
            'customer.exists'                       => 'Selected customer is invalid.',
            'vehicle.required'                      => 'Please select a vehicle.',
            'vehicle.exists'                        => 'Selected vehicle is invalid.',
            'salesperson.exists'                    => 'Selected salesperson is invalid.',
            'type.required'                         => 'Please select a deal type.',
            'type.in'                               => 'Deal type must be either Sale or Lease.',
            'status.required'                       => 'Please select deal status.',
            'price.required'                        => 'Regular price is required.',
            'price.numeric'                         => 'Regular price must be a valid number.',
            'price.min'                             => 'Regular price cannot be negative.',
            'sale_price.required'                   => 'Sale price is required.',
            'sale_price.numeric'                    => 'Sale price must be a valid number.',
            'sale_price.min'                        => 'Sale price cannot be negative.',
            'vat.required'                          => 'VAT is required.',
            'vat.numeric'                           => 'VAT must be a valid number.',
            'vat.min'                               => 'VAT cannot be negative.',
            'interest_rate.required'                => 'Interest rate is required.',
            'interest_rate.numeric'                 => 'Interest rate must be a valid number.',
            'interest_rate.min'                     => 'Interest rate cannot be negative.',
            'commission_amount.numeric'             => 'Commission must be a valid number.',
            'commission_amount.min'                 => 'Commission cannot be negative.',
            'is_business_lease.required'            => 'Please specify business lease availability.',
            'is_business_lease.boolean'             => 'Invalid business lease value.',
            'business_lease_price.numeric'          => 'Business lease price must be a valid number.',
            'business_lease_discount_price.numeric' => 'Business lease sale price must be a valid number.',
            'is_hire_purchase.required'             => 'Please specify hire purchase availability.',
            'is_hire_purchase.boolean'              => 'Invalid hire purchase value.',
            'hire_purchase_price.numeric'           => 'Hire purchase price must be a valid number.',
            'hire_purchase_discount_price.numeric'  => 'Hire purchase sale price must be a valid number.',
        ];

        $request->validate($rules, $messages);

        DB::beginTransaction();

        try {
            Deal::create([
                'deal_number'                   => $this->generateUniqueDealNumber(),
                'user_id'                       => $request->customer,
                'vehicle_id'                    => $request->vehicle,
                'salesperson_id'                => $request->salesperson,
                'type'                          => $request->type,
                'status'                        => $request->status,

                'commission_amount'             => $request->commission_amount ?? 0,

                'price'                         => $request->price,
                'sale_price'                    => $request->sale_price,
                'vat'                           => $request->vat,
                'interest_rate'                 => $request->interest_rate,

                'is_business_lease'             => $request->is_business_lease,
                'business_lease_price'          => $request->business_lease_price,
                'business_lease_discount_price' => $request->business_lease_discount_price,

                'is_hire_purchase'              => $request->is_hire_purchase,
                'hire_purchase_price'           => $request->hire_purchase_price,
                'hire_purchase_discount_price'  => $request->hire_purchase_discount_price,
            ]);

            DB::commit();

            return redirect()->route('superadmin.deals.index')->with('success', 'Deal created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', $e->getMessage());
        }
    }


    public function show(Deal $deal)
    {
        $deal->load(['user', 'vehicle', 'salesperson']);
        return view('superadmin.deal-management.show', compact('deal'));
    }

    public function edit(Deal $deal)
    {
        $this->checkImmutable($deal);
        $customers      = User::orderBy('name')->get();
        $salespeople    = Superadmin::orderBy('firstname')->get();
        $statuses       = ['Draft', 'Pending', 'Completed', 'Cancelled'];
        $vehicles       = Vehicle::get(['id', 'registration', 'model']);
        return view('superadmin.deal-management.edit', compact('deal', 'customers', 'salespeople', 'statuses', 'vehicles'));
    }

    public function update(Request $request, Deal $deal)
    {
        $this->checkImmutable($deal);

        $rules = [
            'customer'                              => 'required|exists:users,id',
            'vehicle'                               => 'required|exists:vehicles,id',
            'salesperson'                           => 'nullable|exists:superadmins,id',
            'type'                                  => 'required|in:Sale,Lease',
            'status'                                => 'required|string',
            'commission_amount'                     => 'nullable|numeric|min:0',
            'price'                                 => 'required|numeric|min:0',
            'sale_price'                            => 'required|numeric|min:0',
            'vat'                                   => 'required|numeric|min:0',
            'interest_rate'                         => 'required|numeric|min:0',
            'is_business_lease'                     => 'required|boolean',
            'business_lease_price'                  => 'nullable|numeric|min:0',
            'business_lease_discount_price'         => 'nullable|numeric|min:0',
            'is_hire_purchase'                      => 'required|boolean',
            'hire_purchase_price'                   => 'nullable|numeric|min:0',
            'hire_purchase_discount_price'          => 'nullable|numeric|min:0',
        ];

        $messages = [
            'customer.required'                     => 'Please select a customer.',
            'customer.exists'                       => 'Selected customer is invalid.',
            'vehicle.required'                      => 'Please select a vehicle.',
            'vehicle.exists'                        => 'Selected vehicle is invalid.',
            'salesperson.exists'                    => 'Selected salesperson is invalid.',
            'type.required'                         => 'Please select a deal type.',
            'type.in'                               => 'Deal type must be either Sale or Lease.',
            'status.required'                       => 'Please select deal status.',
            'price.required'                        => 'Regular price is required.',
            'price.numeric'                         => 'Regular price must be a valid number.',
            'price.min'                             => 'Regular price cannot be negative.',
            'sale_price.required'                   => 'Sale price is required.',
            'sale_price.numeric'                    => 'Sale price must be a valid number.',
            'sale_price.min'                        => 'Sale price cannot be negative.',
            'vat.required'                          => 'VAT is required.',
            'vat.numeric'                           => 'VAT must be a valid number.',
            'vat.min'                               => 'VAT cannot be negative.',
            'interest_rate.required'                => 'Interest rate is required.',
            'interest_rate.numeric'                 => 'Interest rate must be a valid number.',
            'interest_rate.min'                     => 'Interest rate cannot be negative.',
            'commission_amount.numeric'             => 'Commission must be a valid number.',
            'commission_amount.min'                 => 'Commission cannot be negative.',
            'is_business_lease.required'            => 'Please specify business lease availability.',
            'is_business_lease.boolean'             => 'Invalid business lease value.',
            'business_lease_price.numeric'          => 'Business lease price must be a valid number.',
            'business_lease_discount_price.numeric' => 'Business lease sale price must be a valid number.',
            'is_hire_purchase.required'             => 'Please specify hire purchase availability.',
            'is_hire_purchase.boolean'              => 'Invalid hire purchase value.',
            'hire_purchase_price.numeric'           => 'Hire purchase price must be a valid number.',
            'hire_purchase_discount_price.numeric'  => 'Hire purchase sale price must be a valid number.',
        ];

        $request->validate($rules, $messages);

        DB::beginTransaction();

        try {
            Deal::find($deal->id)->update([
                'user_id'                       => $request->customer,
                'vehicle_id'                    => $request->vehicle,
                'salesperson_id'                => $request->salesperson,
                'type'                          => $request->type,
                'status'                        => $request->status,

                'commission_amount'             => $request->commission_amount ?? 0,

                'price'                         => $request->price,
                'sale_price'                    => $request->sale_price,
                'vat'                           => $request->vat,
                'interest_rate'                 => $request->interest_rate,

                'is_business_lease'             => $request->is_business_lease,
                'business_lease_price'          => $request->business_lease_price,
                'business_lease_discount_price' => $request->business_lease_discount_price,

                'is_hire_purchase'              => $request->is_hire_purchase,
                'hire_purchase_price'           => $request->hire_purchase_price,
                'hire_purchase_discount_price'  => $request->hire_purchase_discount_price,
            ]);

            DB::commit();

            return redirect()->route('superadmin.deals.index')->with('success', 'Deal updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Deal $deal)
    {
        if ($deal->status === 'Completed') {
            return back()->with('error', 'Cannot delete a completed deal.');
        }

        $deal->delete();
        return redirect()->route('superadmin.deals.index')->with('success', 'Deal deleted.');
    }

    /**
     * Action: Complete & Lock Deal
     */
    public function complete(Deal $deal)
    {
        $this->checkImmutable($deal);

        DB::transaction(function () use ($deal) {
            $deal->update([
                'status'       => 'Completed',
                'is_immutable' => true,
                'completed_at' => now(),
            ]);

            // Mark vehicle as sold in Module 2
            $deal->vehicle->update(['status' => 'Sold']);
        });

        return back()->with('success', 'Deal finalized and locked.');
    }

    /**
     * Action: Bulk Delete
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with('error', 'No deals selected.');
        }

        // Critical: Only delete deals that are NOT completed
        $deletableDeals = Deal::whereIn('id', $ids)
            ->where('status', '!=', 'Completed')
            ->get();

        $count = $deletableDeals->count();

        foreach ($deletableDeals as $deal) {
            $deal->delete();
        }

        $message = $count . " deals deleted.";
        if (count($ids) > $count) {
            $message .= " (Completed deals were skipped)";
        }

        return redirect()->route('superadmin.deals.index')->with('success', $message);
    }

    private function generateUniqueDealNumber(): string
    {
        do {
            $dealNumber = 'DEAL-' . strtoupper(\Illuminate\Support\Str::random(8));
        } while (Deal::where('deal_number', $dealNumber)->exists());

        return $dealNumber;
    }
}
