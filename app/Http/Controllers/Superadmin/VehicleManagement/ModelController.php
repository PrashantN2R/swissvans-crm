<?php

namespace App\Http\Controllers\Superadmin\VehicleManagement;

use App\Http\Controllers\Controller;
use App\Models\Model;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ModelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:superadmin');
    }

    public function index(Request $request)
    {
        $filter = [
            'name' => $request->name,
            'manufacturer' => $request->manufacturer,
            'cap_id' => $request->cap_id,
        ];

        $models = Model::query();

        if (!empty($filter['name'])) {
            $models->where('name', 'LIKE', "%{$filter['name']}%");
        }
        if (!empty($filter['cap_id'])) {
            $models->where('cap_id', 'LIKE', "%{$filter['cap_id']}%");
        }
        if (!empty($filter['manufacturer'])) {
            $models->where('manufacturer', $filter['manufacturer']);
        }

        $models = $models->orderBy('name')->paginate(20);
        $manufacturers = Manufacturer::orderBy('name')->get();

        return view('superadmin.models.index', compact('models', 'manufacturers', 'filter'));
    }

    public function create()
    {
        $manufacturers = Manufacturer::orderBy('name')->get();
        return view('superadmin.models.create', compact('manufacturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|unique:models,id',
            'name' => 'required|string|max:255',
            'manufacturer' => 'required|numeric|exists:manufacturers,id',
            'cap_id' => 'nullable|string',
            'capmod_id' => 'nullable|string',
            'introduced' => 'nullable|string',
            'discount_percent' => 'nullable|numeric',
            'profit_percent' => 'nullable|numeric',
            'profit' => 'nullable|numeric',
        ]);

        Model::create($request->all());

        return redirect()->route('superadmin.models.index')
            ->with('success', 'Vehicle Model created successfully.');
    }

    public function edit($id)
    {
        $model = Model::findOrFail($id);
        $manufacturers = Manufacturer::orderBy('name')->get();

        return view('superadmin.models.edit', compact('model', 'manufacturers'));
    }

    public function update(Request $request, $id)
    {
        $model = Model::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'manufacturer' => 'required|numeric|exists:manufacturers,id',
            'cap_id' => 'nullable|string',
            'capmod_id' => 'nullable|string',
            'introduced' => 'nullable|string',
            'discount_percent' => 'nullable|numeric',
            'profit_percent' => 'nullable|numeric',
            'profit' => 'nullable|numeric',
        ]);

        $model->update($request->all());

        return redirect()->route('superadmin.models.index')
            ->with('success', 'Vehicle Model updated successfully.');
    }

    public function destroy($id)
    {
        Model::findOrFail($id)->delete();

        return back()->with('success', 'Vehicle Model deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        Model::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true]);
    }

    public function changeStatus($id)
    {
        $model = Model::findOrFail($id);
        $model->status = !$model->status;
        $model->save();

        return back()->with('success', 'Status updated');
    }

    public function updateDiscount(Request $request, $id)
    {
        $request->validate([
            'discount_percent' => 'required|numeric|min:0|max:100',
        ]);

        $model = Model::findOrFail($id);
        $model->discount_percent = $request->discount_percent;
        $model->save();

        return response()->json([
            'success' => true,
            'message' => 'Discount updated successfully!',
            'value' => $model->discount_percent,
        ]);
    }

    public function updateProfit(Request $request, $id)
    {
        $request->validate([
            'profit' => 'required|numeric|min:0',
        ]);

        $model = Model::findOrFail($id);
        $model->profit = $request->profit;
        $model->save();

        return response()->json([
            'success' => true,
            'message' => 'Profit updated successfully!',
            'value' => $model->profit,
        ]);
    }

     public function hpiModels(Request $request)
    {
        $request->validate(['manCode' => 'required|string']);

        // Artisan::call('app:sync-models-for ' . $request->manCode);

        return response()->json(
            Model::where('cap_id', $request->manCode)
                ->select('capmod_id', 'name')
                ->get()
        );
    }
}
