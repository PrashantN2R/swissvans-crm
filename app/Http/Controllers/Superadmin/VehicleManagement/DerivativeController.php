<?php

namespace App\Http\Controllers\Superadmin\VehicleManagement;

use App\Http\Controllers\Controller;
use App\Models\Derivative;
use App\Models\Manufacturer;
use App\Models\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DerivativeController extends Controller
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
            'model' => $request->model,
        ];

        $derivatives = Derivative::query();

        if ($filter['name']) {
            $derivatives->where('name', 'LIKE', "%{$filter['name']}%");
        }
        if ($filter['manufacturer']) {
            $derivatives->where('manufacturer', $filter['manufacturer']);
        }
        if ($filter['model']) {
            $derivatives->where('model', $filter['model']);
        }

        $derivatives = $derivatives->orderBy('id')->paginate(20);

        $manufacturers = Manufacturer::orderBy('name')->get();
        $models = Model::orderBy('name')->get();

        return view('superadmin.derivatives.index', compact('derivatives', 'manufacturers', 'models', 'filter'));
    }

    public function create()
    {
        return view('superadmin.derivatives.create', [
            'manufacturers' => Manufacturer::orderBy('name')->get(),
            'models' => Model::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|unique:derivatives,id',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'model_id' => 'required|exists:models,id',
            'name' => 'required',
            'discount_percent' => 'nullable|numeric',
            'profit' => 'nullable|numeric',
        ]);

        Derivative::create($request->all());

        return redirect()->route('superadmin.derivatives.index')
            ->with('success', 'Derivative created successfully.');
    }

    public function edit($id)
    {
        return view('superadmin.derivatives.edit', [
            'item' => Derivative::findOrFail($id),
            'manufacturers' => Manufacturer::orderBy('name')->get(),
            'models' => Model::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Derivative::findOrFail($id);

        $request->validate([
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'model_id' => 'required|exists:models,id',
            'name' => 'required',
            'discount_percent' => 'nullable|numeric',
            'profit' => 'nullable|numeric',
        ]);

        $item->update($request->all());

        return redirect()->route('superadmin.derivatives.index')
            ->with('success', 'Derivative updated successfully.');
    }

    public function destroy($id)
    {
        Derivative::where('id', $id)->delete();
        return back()->with('success', 'Derivative deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        Derivative::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true]);
    }

    public function changeStatus($id)
    {
        $item = Derivative::findOrFail($id);
        $item->status = !$item->status;
        $item->save();

        return back()->with('success', 'Status changed.');
    }

    public function updateDiscount(Request $request, $id)
    {
        $request->validate([
            'discount_percent' => 'required|numeric|min:0|max:100',
        ]);

        $derivative = Derivative::findOrFail($id);
        $derivative->discount_percent = $request->discount_percent;
        $derivative->save();

        return response()->json([
            'success' => true,
            'message' => 'Discount updated successfully!',
            'value' => $derivative->discount_percent,
        ]);
    }

    public function updateProfit(Request $request, $id)
    {
        $request->validate([
            'profit' => 'required|numeric|min:0',
        ]);

        $derivative = Derivative::findOrFail($id);
        $derivative->profit = $request->profit;
        $derivative->save();

        return response()->json([
            'success' => true,
            'message' => 'Profit updated successfully!',
            'value' => $derivative->profit,
        ]);
    }

     public function hpiDerivatives(Request $request)
    {
        $request->validate(['modCode' => 'required|string']);

        Artisan::call('app:sync-derivatives-for ' . $request->modCode);

        return response()->json(
            Derivative::where('capmod_id', $request->modCode)
                ->select('derivative_id', 'name')
                ->get()
        );
    }
}
