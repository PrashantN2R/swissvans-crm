<?php

namespace App\Http\Controllers\Superadmin\VehicleManagement;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\User;
use App\Models\VanType;
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
            ->when($request->manufacturer, fn($q) => $q->where('hpi_mancode', $request->manufacturer))
            ->when($request->model, fn($q) => $q->where('hpi_modcode', $request->model))
            ->orderBy('id', 'desc')
            ->paginate(100);

        $manufacturers  = Manufacturer::orderBy('name')->get();
        $models         = Model::orderBy('name')->get();

        $fillmodels     =  $request->manufacturer ? Model::where('cap_id', $request->manufacturer)->get() : collect([]);

        return view('superadmin.vehicles.list', compact('vehicles', 'manufacturers', 'models', 'fillmodels'));
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create()
    {
        $customers          = User::get(['id', 'name']);
        $manufacturers      = Manufacturer::orderBy('name')->get(['cap_id', 'name']);
        $van_type           = VanType::get(['name']);
        return view('superadmin.vehicles.create', compact('manufacturers', 'van_type', 'customers'));
    }

    /**
     * Store a newly created vehicle in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'registration'                  => 'required|string|max:20',
            'vin'                           => 'required|string|max:50',
            'year'                          => 'required|string|max:4',
            'hpi_mancode'                   => 'required',
            'hpi_modcode'                   => 'required',
            'hpi_derivative'                => 'required',
            'title'                         => 'required|string|max:255',
            'short_description'             => 'required|string',
            'description'                   => 'required|string',
            'status'                        => 'required|in:0,1',
            'stock_status'                  => 'required|in:in_stock,out_of_stock',
            'is_business_lease'             => 'required|in:0,1',
            'is_hire_purchase'              => 'required|in:0,1',
        ]);

        $vehicle                            = Vehicle::create([
            'user_id'                       => $request->owner ? $request->owner : null,
            'title'                         => $request->title,
            'registration'                  => $request->registration,
            'vin'                           => $request->vin,
            'model'                         => $request->model,
            'year'                          => $request->year,
            'short_description'             => $request->short_description,
            'description'                   => $request->description,
            'price'                         => $request->price,
            'sale_price'                    => $request->sale_price,
            'vat'                           => $request->vat,
            'interest_rate'                 => $request->interest_rate,
            'is_business_lease'             => $request->is_business_lease,
            'business_lease_price'          => $request->is_business_lease ? $request->business_lease_price : null,
            'business_lease_discount_price' => $request->is_business_lease ?  $request->business_lease_discount_price : null,
            'is_hire_purchase'              => $request->is_hire_purchase,
            'hire_purchase_price'           => $request->is_hire_purchase ? $request->hire_purchase_price : null,
            'hire_purchase_discount_price'  => $request->is_hire_purchase ? $request->hire_purchase_discount_price : null,
            'van_type'                      => $request->van_type,
            'hpi_mancode'                   => $request->hpi_mancode,
            'hpi_modcode'                   => $request->hpi_modcode,
            'hpi_derivative'                => $request->hpi_derivative,
            'meta_title'                    => $request->meta_title,
            'meta_description'              => $request->meta_description,
            'meta_keywords'                 => $request->meta_keywords,
            'status'                        => $request->status,
            'stock_status'                  => $request->stock_status,
        ]);

        if ($request->hasFile('thumbnail')) {
            $upload                         = $this->handleImageUpload($request->thumbnail, 'uploads/vehicles/' . $vehicle->id . '/thumbnails');

            # basename() strips away the directory path and returns just the file name
            $filename                       = basename($upload['destinationPath']);

            $vehicle->update(['thumbnail' => $filename]);
        }

        $this->processGalleryImages($request, $vehicle);

        return redirect()->route('superadmin.vehicles.index')->with('success', 'Vehicle created!');
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function show($id)
    {
        # Load with images relationship to show them in the edit gallery.
        $vehicle            = Vehicle::with('images')->findOrFail($id);
        return view('superadmin.vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit($id)
    {
        # Load with images relationship to show them in the edit gallery.
        $vehicle            = Vehicle::with('images')->findOrFail($id);
        $manufacturers      = Manufacturer::orderBy('name')->get(['cap_id', 'name']);
        $van_type           = VanType::get(['name']);
        $customers          = User::get(['id', 'name']);
        return view('superadmin.vehicles.edit', compact('vehicle', 'manufacturers', 'van_type', 'customers'));
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $request->validate([
            'registration'                   => 'required|string|max:20',
            'vin'                            => 'required|string|max:50',
            'year'                           => 'required|string|max:4',
            'hpi_mancode'                    => 'required',
            'hpi_modcode'                    => 'required',
            'hpi_derivative'                 => 'required',
            'title'                          => 'required|string|max:255',
            'short_description'              => 'required|string',
            'description'                    => 'required|string',
            'status'                         => 'required|in:0,1',
            'stock_status'                   => 'required|in:in_stock,out_of_stock',
            'is_business_lease'              => 'required|in:0,1',
            'is_hire_purchase'               => 'required|in:0,1',
        ]);

        if ($request->hasFile('thumbnail')) {

            if ($vehicle->thumbnail) Storage::disk('public')->delete($vehicle->thumbnail);

            $upload                          = $this->handleImageUpload($request->thumbnail, 'uploads/vehicles/' . $id . '/thumbnails');

            $filename                        = basename($upload['destinationPath']);

            $vehicle->update(['thumbnail'    => $filename]);
        }

        $vehicle->update([
            'user_id'                       => $request->owner ? $request->owner : null,
            'title'                         => $request->title,
            'registration'                  => $request->registration,
            'vin'                           => $request->vin,
            'model'                         => $request->model,
            'year'                          => $request->year,
            'short_description'             => $request->short_description,
            'description'                   => $request->description,
            'price'                         => $request->price,
            'sale_price'                    => $request->sale_price,
            'vat'                           => $request->vat,
            'interest_rate'                 => $request->interest_rate,
            'is_business_lease'             => $request->is_business_lease,
            'business_lease_price'          => $request->is_business_lease ? $request->business_lease_price : null,
            'business_lease_discount_price' => $request->is_business_lease ?  $request->business_lease_discount_price : null,
            'is_hire_purchase'              => $request->is_hire_purchase,
            'hire_purchase_price'           => $request->is_hire_purchase ? $request->hire_purchase_price : null,
            'hire_purchase_discount_price'  => $request->is_hire_purchase ? $request->hire_purchase_discount_price : null,
            'van_type'                      => $request->van_type,
            'hpi_mancode'                   => $request->hpi_mancode,
            'hpi_modcode'                   => $request->hpi_modcode,
            'hpi_derivative'                => $request->hpi_derivative,
            'meta_title'                    => $request->meta_title,
            'meta_description'              => $request->meta_description,
            'meta_keywords'                 => $request->meta_keywords,
            'status'                        => $request->status,
            'stock_status'                  => $request->stock_status,
        ]);

        $this->processGalleryImages($request, $vehicle);



        return redirect()->route('superadmin.vehicles.index')->with('success', 'Vehicle updated!');
    }

    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy($id)
    {
        $vehicle                = Vehicle::with('images')->findOrFail($id);

        if ($vehicle->thumbnail) Storage::disk('public')->delete($vehicle->thumbnail);

        foreach ($vehicle->images as $img) {
            Storage::disk('public')->delete($img->path);
        }

        Storage::disk('public')->deleteDirectory("uploads/vehicles/{$vehicle->id}");

        $vehicle->delete();

        return back()->with('success', 'Vehicle deleted.');
    }

    /**
     * Bulk Delete
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        Vehicle::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        if ($request->hasFile('file')) {

            $file               = $request->file('file');

            $filename           = time() . '_' . $file->getClientOriginalName();

            $path               = $file->storeAs('uploads/vehicles/content', $filename, 'public');

            return response()->json([

                'success'       => true,

                'location'      => asset('storage/' . $path),

                'filename'      => $filename,

                'path'          => $path

            ]);
        }

        return response()->json([

            'success'           => false,

            'message'           => 'No file uploaded'

        ], 400);
    }

    /**
     * Delete a single gallery attachment.
     */
    public function deleteAttachment(Request $request)
    {
        # Validate that the ID was actually passed in the request body
        $request->validate([
            'id' => 'required|exists:vehicle_images,id'
        ]);

        try {
            # Access ID via $request->id
            $image = VehicleImage::findOrFail($request->id);

            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }

            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Processing error: ' . $e->getMessage()
            ], 500);
        }
    }
    /* ============================
     | PRIVATE HELPERS
     ============================ */

    private function processGalleryImages(Request $request, $vehicle)
    {
        if ($request->hasFile('images') && is_array($request->images)) {
            foreach ($request->images as $key => $imageFile) {
                if (empty($imageFile)) continue;
                $imgUp = $this->handleImageUpload($imageFile, "uploads/vehicles/{$vehicle->id}/images");
                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'attachment' => $imgUp["uniqueName"],
                    'extension'  => $imgUp["extension"],
                    'path'       => $imgUp["destinationPath"],
                    'sort_order' => $key,
                ]);
            }
        }
    }

    private function handleImageUpload($file, $path)
    {
        $extension                  = is_object($file) ? $file->getClientOriginalExtension() : 'webp';
        $uniqueName                 = Str::uuid() . '.' . $extension;
        $destinationPath            = $path . '/' . $uniqueName;

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

    public function getDetails($id)
    {
        // Fetch the user with necessary relationships
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Vehicle not found'
            ], 404);
        }

        // Format data for the frontend
        $data = [
            'customer'                          => $vehicle->user->name,
            'title'                             => $vehicle->title,
            'slug'                              => $vehicle->slug,
            'registration'                      => $vehicle->registration,
            'vin'                               => $vehicle->vin,
            'model'                             => $vehicle->model,
            'year'                              => $vehicle->year,
            'short_description'                 => $vehicle->short_description,
            'description'                       => $vehicle->description,
            'price'                             => $vehicle->price,
            'sale_price'                        => $vehicle->sale_price,
            'vat'                               => $vehicle->vat,
            'interest_rate'                     => $vehicle->interest_rate,
            'is_business_lease'                 => $vehicle->is_business_lease,
            'business_lease_price'              => $vehicle->business_lease_price,
            'business_lease_discount_price'     => $vehicle->business_lease_discount_price,
            'is_hire_purchase'                  => $vehicle->is_hire_purchase,
            'hire_purchase_price'               => $vehicle->hire_purchase_price,
            'hire_purchase_discount_price'      => $vehicle->hire_purchase_discount_price,
            'van_type'                          => $vehicle->van_type,
            'manufacturer'                      => $vehicle->manufacturerData->name,
            'model'                             => $vehicle->modelData->name,
            'variant'                           => $vehicle->variantData->name,
            'thumbnail'                         => $vehicle->thumbnail_path,
            'meta_title'                        => $vehicle->meta_title,
            'meta_description'                  => $vehicle->meta_description,
            'meta_keywords'                     => $vehicle->meta_keywords,
            'status'                            => $vehicle->status,
            'stock_status'                      => $vehicle->stock_status == "in_stock" ? "In Stock" : "Out of Stock"
        ];

        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }
}
