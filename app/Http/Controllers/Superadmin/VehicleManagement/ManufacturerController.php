<?php

namespace App\Http\Controllers\Superadmin\VehicleManagement;;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:superadmin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filters
        $filter = [
            'name'   => $request->name,
            'cap_id' => $request->cap_id,
            'status' => $request->status,
        ];

        $manufacturers = Manufacturer::query();

        if (!empty($filter['name'])) {
            $manufacturers->where('name', 'LIKE', "%{$filter['name']}%");
        }
        if (!empty($filter['cap_id'])) {
            $manufacturers->where('cap_id', 'LIKE', "%{$filter['cap_id']}%");
        }
        if (!empty($filter['status'])) {
            $manufacturers->where('status', $filter['status'] == "active" ? 1 : 0);
        }

        $manufacturers = $manufacturers
            ->orderBy('name')
            ->paginate(20);

        return view('superadmin.manufacturers.index', compact('manufacturers', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.manufacturers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id'              => 'required|numeric|unique:manufacturers,id',
            'name'            => 'required|string|max:255',
            'cap_id'          => 'nullable|string|max:100',
            'delivery_charge' => 'nullable|numeric',
            'status'          => 'required|in:0,1',
        ]);

        Manufacturer::create([
            'id'              => $request->id,
            'name'            => $request->name,
            'cap_id'          => $request->cap_id,
            'delivery_charge' => $request->delivery_charge ?? 0,
            'status'          => $request->status,
        ]);

        return redirect()
            ->route('superadmin.manufacturers.index')
            ->with('success', 'Manufacturer created successfully.');
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        return view('superadmin.manufacturers.edit', compact('manufacturer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $manufacturer = Manufacturer::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:255',
            'cap_id'          => 'nullable|string|max:100',
            'delivery_charge' => 'nullable|numeric',
            'status'          => 'required|in:0,1',
        ]);

        $manufacturer->update([
            'name'            => $request->name,
            'cap_id'          => $request->cap_id,
            'delivery_charge' => $request->delivery_charge ?? 0,
            'status'          => $request->status,
        ]);

        return redirect()
            ->route('superadmin.manufacturers.index')
            ->with('success', 'Manufacturer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Manufacturer::where('id', $id)->delete();

        return redirect()
            ->route('superadmin.manufacturers.index')
            ->with('success', 'Manufacturer deleted successfully.');
    }

    /**
     * Bulk Delete
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        Manufacturer::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Change Status (toggle active/inactive)
     */
    public function changeStatus($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);

        $manufacturer->status = !$manufacturer->status;
        $manufacturer->save();

        return redirect()
            ->route('superadmin.manufacturers.index')
            ->with('success', 'Status updated successfully.');
    }

    public function updateDeliveryCharge(Request $request, $id)
    {
        $request->validate([
            'delivery_charge' => 'required|numeric|min:0',
        ]);

        $manufacturer = Manufacturer::findOrFail($id);

        $manufacturer->delivery_charge = $request->delivery_charge;
        $manufacturer->save();

        return response()->json([
            'success' => true,
            'message' => 'Delivery Charge updated successfully.',
            'delivery_charge' => $manufacturer->delivery_charge,
        ]);
    }
}
