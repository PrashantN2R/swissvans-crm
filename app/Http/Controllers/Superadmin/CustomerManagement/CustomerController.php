<?php

namespace App\Http\Controllers\Superadmin\CustomerManagement;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;

class CustomerController extends Controller
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
        $filter                 = [];
        $filter['name']         = $request->name;
        $filter['email']        = $request->email;
        $filter['phone']        = $request->phone;
        $filter['status']       = $request->status;

        $users            = User::query();
        $users            = isset($filter['name']) ? $users->where(DB::raw("concat(firstname, ' ', lastname)"), 'LIKE', '%' . $filter['name'] . '%') : $users;
        $users            = isset($filter['email']) ? $users->where('email', 'LIKE', '%' . $filter['email'] . '%') : $users;
        $users            = isset($filter['phone']) ? $users->where('phone', 'LIKE', '%' . $filter['phone'] . '%') : $users;

        if (isset($filter['status'])) {
            if ($filter['status'] == 'Yes') {
                $users      = $users->where('status', true);
            }

            if ($filter['status'] == 'No') {
                $users      = $users->where('status', false);
            }
        }

        $users          = $users->orderBy('id', 'desc')->paginate(20);

        return view('superadmin.customer-management.list', compact('users', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('superadmin.customer-management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'     => ['required', 'min:8', 'unique:users'],
            'gender'    => ['required'],
            'status'    => ['required']
        ]);

        $user                         = new User();
        $user->firstname              = $request->firstname;
        $user->lastname               = $request->lastname;
        $user->email                  = $request->email;
        $user->password               = Hash::make('Temp#@785612');
        $user->dialcode               = $request->dialcode;
        $user->phone                  = $request->phone;
        $user->iso2                   = $request->iso2;
        $user->status                 = $request->status;
        $user->gender                 = $request->gender;
        $user->address                = $request->address;
        $user->city                   = $request->city;
        $user->state                  = $request->state;
        $user->zipcode                = $request->zipcode;
        $user->email_verified_at      = now();
        $user->save();

        if ($request->hasFile('avatar')) {
            $image                    = $request->file('avatar');

            $extension                = $image->getClientOriginalExtension();
            $timestamp                = now()->format('Ymd_His');
            $fileName                 = "{$timestamp}.{$extension}";

            $filePath                 = $image->storeAs("uploads/customers/" . $user->slug, $fileName, 'public');

            User::find($user->id)->update([
                'avatar'              => $fileName,
                'avatar_path'         => URL::asset('storage/' . $filePath)
            ]);
        }

        if ($request->redirect == "vehicle") {
            if ($request->vehicle_id) {
                return redirect()->route('superadmin.vehicles.edit', $request->vehicle_id)->with('success', 'Customer created successfully!');
            } else {
                return redirect()->route('superadmin.vehicles.create')->with('success', 'Customer created successfully!');
            }
        }
        return redirect()->route('superadmin.customers.index')->with('success', 'Customer created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $user          = User::findBySlug($slug);
        $user->avatar  = isset($user->avatar_path) ? $user->avatar_path : "https://placehold.co/150x150/E3E1FF/0266DA?text=" . $user->initials;
        $user->country = Country::where('code', $user->iso2)->first()->name;

        return view('superadmin.customer-management.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $user          = User::findBySlug($slug);
        $user->avatar  = isset($user->avatar_path) ? $user->avatar_path : "https://placehold.co/150x150/E3E1FF/7272DC?text=" . $user->initials;

        return view('superadmin.customer-management.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'phone'     => ['required', 'min:8', 'unique:users,phone,' . $id],
            'gender'    => ['required'],
            'status'    => ['required'],
        ]);

        $user                  = User::find($id);
        $user->firstname       = $request->firstname;
        $user->lastname        = $request->lastname;
        $user->email           = $request->email;
        $user->dialcode        = $request->dialcode;
        $user->phone           = $request->phone;
        $user->iso2            = $request->iso2;
        $user->status          = $request->status;
        $user->gender          = $request->gender;
        $user->address         = $request->address;
        $user->city            = $request->city;
        $user->state           = $request->state;
        $user->zipcode         = $request->zipcode;
        $user->save();

        $user                  = User::find($id);

        if ($request->hasFile('avatar')) {
            $image                    = $request->file('avatar');

            $extension                = $image->getClientOriginalExtension();
            $timestamp                = now()->format('Ymd_His');
            $fileName                 = "{$timestamp}.{$extension}";

            $filePath                 = $image->storeAs("uploads/customers/" . $user->slug, $fileName, 'public');

            User::find($user->id)->update([
                'avatar'              => $fileName,
                'avatar_path'         => URL::asset('storage/' . $filePath)
            ]);
        }

        return redirect()->route('superadmin.customers.index')->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        return redirect()->route('superadmin.customers.index')->with('success', 'Customer deleted successfully!');
    }

    public function changeStatus($id)
    {
        $admin = User::find($id);
        if ($admin->status == true) {
            User::find($id)->update(['status' => false]);
            return redirect()->route('superadmin.customers.index')->with('warning', 'Customer has been disabled successfully!');
        } else {
            User::find($id)->update(['status' => true]);
            return redirect()->route('superadmin.customers.index')->with('success', 'Customer has been enabled successfully!');
        }
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'min:8', 'confirmed']
        ]);
        User::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
        return redirect()->route('superadmin.customers.index')->with('success', 'Customer password has been reset successfully!');
    }

    public function bulkDelete(Request $request)
    {
        User::whereIn('id', $request->customers)->delete();
        return response()->json(['success' => 'Customers deleted successfully!'], 200);
    }
}
