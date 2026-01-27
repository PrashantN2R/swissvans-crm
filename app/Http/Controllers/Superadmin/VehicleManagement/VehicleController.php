<?php

namespace App\Http\Controllers\Superadmin\VehicleManagement;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\HpiCapVehicles;

class VehicleController extends Controller
{
    use HpiCapVehicles;

    public function __construct()
    {
        $this->middleware('auth:superadmin');
    }

    /**
     * Display a listing of the vehicles.
     */
     public function index(Request $request)
    {
        $vehicles = Vehicle::when($request->title, fn($q) => $q->where('title', 'LIKE', "%{$request->title}%"))
            ->when($request->status !== null && $request->status !== '', fn($q) => $q->where('status', $request->status))
            ->when($request->registration, fn($q) => $q->where('registration', $request->registration))
             ->when($request->year, fn($q) => $q->where('year', $request->year))
            ->when($request->min_price, fn($q) => $q->where('price', '>=', $request->min_price))
            ->when($request->max_price, fn($q) => $q->where('price', '<=', $request->max_price))
            ->when($request->stock_status, fn($q) => $q->where('stock_status', $request->stock_status))
            ->when($request->manufacturer,fn($q) => $q->where('hpi_mancode',$request->manufacturer))
            ->when($request->model,fn($q) => $q->where('hpi_modcode',$request->model))
            ->orderBy('id', 'desc')
            ->paginate(20);

        $manufacturers  = Manufacturer::orderBy('name')->get();
        $models         = Model::orderBy('name')->get();

        $fillmodels     =  $request->manufacturer ? Model::where('cap_id', $request->manufacturer)->get() : collect([]);

        return view('superadmin.vehicles.list', compact('vehicles','manufacturers','models','fillmodels'));
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create()
    {
        // Add any data needed for dropdowns here, e.g., $categories = Category::all();
        return view('superadmin.vehicles.create');
    }

    /**
     * Store a newly created vehicle in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'registration'      => 'required|string|max:20',
            'vin'               => 'required|string|max:50',
            'model'             => 'required|string|max:255',
            'year'              => 'required|string|max:4',
            'hpi_mancode'       => 'required',
            'hpi_modcode'       => 'required',
            'hpi_derivative'    => 'required',
            'title'             => 'required|string|max:255',
            'short_description' => 'required|string',
            'description'       => 'required|string',
            'status'            => 'required|in:0,1',
            'stock_status'      => 'required|in:in_stock,out_of_stock',
            'is_business_lease' => 'required|in:0,1',
            'is_hire_purchase'  => 'required|in:0,1',
        ]);

        $vehicle = Vehicle::create([
            'user_id'           => $request->owner ? $request->owner : null,
            'title'             => $request->title,
            'slug'              => Str::slug($request->title) . '-' . time(),
            'registration'      => $request->registration,
            'vin'               => $request->vin,
            'model'             => $request->model,
            'year'              => $request->year,
            'short_description' => $request->short_description,
            'description'       => $request->description,
            'price'             => $request->price,
            'sale_price'        => $request->sale_price,
            'vat'               => $request->vat,
            'interest_rate'     => $request->interest_rate,
            'is_business_lease' => $request->is_business_lease,
            'business_lease_price'          => $request->business_lease_price,
            'business_lease_discount_price' => $request->business_lease_discount_price,
            'is_hire_purchase'              => $request->is_hire_purchase,
            'hire_purchase_price'           => $request->hire_purchase_price,
            'hire_purchase_discount_price'  => $request->hire_purchase_discount_price,
            'van_type'          => $request->van_type,
            'hpi_mancode'       => $request->hpi_mancode,
            'hpi_modcode'       => $request->hpi_modcode,
            'hpi_derivative'    => $request->hpi_derivative,
            'meta_title'        => $request->meta_title,
            'meta_description'  => $request->meta_description,
            'meta_keywords'     => $request->meta_keywords,
            'status'            => $request->status,
            'stock_status'      => $request->stock_status,
        ]);

        if ($request->filled('thumbnail')) {
            $upload = $this->handleImageUpload($request->thumbnail, 'uploads/vehicles/'.$vehicle->id.'/thumbnails');
            $vehicle->update(['thumbnail' => $upload['destinationPath']]);
        }

        $this->processGalleryImages($request, $vehicle);

        return redirect()->route('superadmin.vehicles.index')->with('success', 'Vehicle created!');
    }

     /**
     * Show the form for editing the specified vehicle.
     */
    public function show($id)
    {
        // Load with images relationship to show them in the edit gallery
        $vehicle = Vehicle::with('images')->findOrFail($id);

        return view('superadmin.vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit($id)
    {
        // Load with images relationship to show them in the edit gallery
        $vehicle = Vehicle::with('images')->findOrFail($id);

        return view('superadmin.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $request->validate([
            'registration' => 'required|string',
            'vin'          => 'required|string',
            'model'        => 'required|string',
            'year'         => 'required|string',
            'title'        => 'required|string',
        ]);

        if ($request->filled('thumbnail')) {
            if ($vehicle->thumbnail) Storage::disk('public')->delete($vehicle->thumbnail);
            $upload = $this->handleImageUpload($request->thumbnail, 'uploads/vehicles/'.$id.'/thumbnails');
            $vehicle->thumbnail = $upload['destinationPath'];
        }

        $vehicle->update($request->except(['images', 'thumbnail', 'up_alt_images', 'alt_images']));

        $this->processGalleryImages($request, $vehicle);

        if ($request->has('up_alt_images')) {
            foreach ($request->up_alt_images as $img_id => $alt_text) {
                VehicleImage::where('id', $img_id)->update(['alt' => $alt_text]);
            }
        }

        return redirect()->route('superadmin.vehicles.index')->with('success', 'Vehicle updated!');
    }

    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::with('images')->findOrFail($id);
        if ($vehicle->thumbnail) Storage::disk('public')->delete($vehicle->thumbnail);
        foreach ($vehicle->images as $img) {
            Storage::disk('public')->delete($img->path);
        }
        Storage::disk('public')->deleteDirectory("uploads/vehicles/{$vehicle->id}");
        $vehicle->delete();

        return back()->with('success', 'Vehicle deleted.');
    }

    /**
     * Delete a single gallery attachment.
     */
    public function deleteAttachment($id)
    {
        $image = VehicleImage::findOrFail($id);
        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }
        $image->delete();
        return back()->with('success', 'Image removed.');
    }

    /* ============================
     | PRIVATE HELPERS
     ============================ */

    private function processGalleryImages(Request $request, $vehicle)
    {
        if ($request->filled('images') && is_array($request->images)) {
            foreach ($request->images as $key => $imageFile) {
                if (empty($imageFile)) continue;
                $imgUp = $this->handleImageUpload($imageFile, "uploads/vehicles/{$vehicle->id}/images");
                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'attachment' => $imgUp["uniqueName"],
                    'extension'  => $imgUp["extension"],
                    'path'       => $imgUp["destinationPath"],
                    'alt'        => $request->alt_images[$key] ?? $vehicle->title,
                    'sort_order' => $key,
                ]);
            }
        }
    }

    private function handleImageUpload($file, $path)
    {
        $extension = is_object($file) ? $file->getClientOriginalExtension() : 'webp';
        $uniqueName = Str::uuid() . '.' . $extension;
        $destinationPath = $path . '/' . $uniqueName;

        if (is_object($file)) {
            Storage::disk('public')->putFileAs($path, $file, $uniqueName);
        } else {
            if (preg_match('/^data:image\/(\w+);base64,/', $file)) {
                $data = substr($file, strpos($file, ',') + 1);
                $data = base64_decode($data);
                Storage::disk('public')->put($destinationPath, $data);
            } else {
                Storage::disk('public')->put($destinationPath, file_get_contents($file));
            }
        }

        return [
            "uniqueName"      => $uniqueName,
            "extension"       => $extension,
            "destinationPath" => $destinationPath,
        ];
    }
}
