<?php

namespace App\Http\Controllers\Superadmin\DealManagement;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Superadmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DealController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:superadmin');
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
        // Logic to fetch customers and available vehicles for dropdowns
        return view('superadmin.deal-management.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'        => 'required|exists:users,id',
            'vehicle_id'     => 'required|exists:vehicles,id',
            'salesperson_id' => 'required|exists:superadmins,id',
            'type'           => 'required|in:Sale,Lease',
            'sale_price'     => 'required|numeric|min:0',
            // Add other financial validations as needed
        ]);

        // Generate a unique deal number
        $validated['deal_number'] = 'DEAL-' . strtoupper(Str::random(8));

        $deal = Deal::create($validated);

        return redirect()->route('superadmin.deals.show', $deal->id)
            ->with('success', 'Deal created successfully.');
    }

    public function show(Deal $deal)
    {
        $deal->load(['user', 'vehicle', 'salesperson']);
        return view('superadmin.deal-management.show', compact('deal'));
    }

    public function edit(Deal $deal)
    {
        $this->checkImmutable($deal);
        return view('superadmin.deal-management.edit', compact('deal'));
    }

    public function update(Request $request, Deal $deal)
    {
        $this->checkImmutable($deal);

        $validated = $request->validate([
            'status'     => 'required|in:Draft,Pending,Cancelled',
            'sale_price' => 'numeric|min:0',
            'notes'      => 'nullable|string',
        ]);

        $deal->update($validated);

        return redirect()->route('superadmin.deals.show', $deal->id)
            ->with('success', 'Deal updated.');
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
}
