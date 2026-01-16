<?php

namespace App\Http\Controllers\Superadmin\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Superadmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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

        $users            = Superadmin::query();
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

        return view('superadmin.user-management.users.list', compact('users', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');
        return view('superadmin.user-management.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:superadmins'],
            'phone'     => ['required', 'min:8', 'unique:superadmins'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'gender'    => ['required'],
            'status'    => ['required'],
            'role'      => ['required']
        ]);

        $user                         = new Superadmin();
        $user->firstname              = $request->firstname;
        $user->lastname               = $request->lastname;
        $user->email                  = $request->email;
        $user->password               = Hash::make($request->password);
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

            $filePath                 = $image->storeAs("uploads/superadmins/" . $user->slug, $fileName, 'public');

            Superadmin::find($user->id)->update([
                'avatar'              => $fileName,
                'avatar_path'         => URL::asset('storage/' . $filePath)
            ]);
        }

        $user->assignRole($request->role);

        return redirect()->route('superadmin.users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $user          = Superadmin::findBySlug($slug);
        $user->avatar  = isset($user->avatar_path) ? $user->avatar_path : "https://placehold.co/150x150/E3E1FF/0266DA?text=" . $user->initials;
        $user->country = Country::where('code', $user->iso2)->first()->name;

        return view('superadmin.user-management.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $user          = Superadmin::findBySlug($slug);
        $roles         = Role::pluck('name', 'id');
        $user->avatar  = isset($user->avatar_path) ? $user->avatar_path : "https://placehold.co/150x150/E3E1FF/7272DC?text=" . $user->initials;

        return view('superadmin.user-management.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:superadmins,email,' . $id],
            'phone'     => ['required', 'min:8', 'unique:superadmins,phone,' . $id],
            'gender'    => ['required'],
            'status'    => ['required'],
            'role'      => ['required']
        ]);

        $user                  = Superadmin::find($id);
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

        $user                  = Superadmin::find($id);

        if ($request->hasFile('avatar')) {
            $image                    = $request->file('avatar');

            $extension                = $image->getClientOriginalExtension();
            $timestamp                = now()->format('Ymd_His');
            $fileName                 = "{$timestamp}.{$extension}";

            $filePath                 = $image->storeAs("uploads/superadmins/" . $user->slug, $fileName, 'public');

            Superadmin::find($user->id)->update([
                'avatar'              => $fileName,
                'avatar_path'         => URL::asset('storage/' . $filePath)
            ]);
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('superadmin.users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Superadmin::find($id)->delete();
        return redirect()->route('superadmin.users.index')->with('success', 'User deleted successfully!');
    }

    public function changeStatus($id)
    {
        $admin = Superadmin::find($id);
        if ($admin->status == true) {
            Superadmin::find($id)->update(['status' => false]);
            return redirect()->route('superadmin.users.index')->with('warning', 'User has been disabled successfully!');
        } else {
            Superadmin::find($id)->update(['status' => true]);
            return redirect()->route('superadmin.users.index')->with('success', 'User has been enabled successfully!');
        }
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'min:8', 'confirmed']
        ]);
        Superadmin::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
        return redirect()->route('superadmin.users.index')->with('success', 'User password has been reset successfully!');
    }

    public function bulkDelete(Request $request)
    {
        Superadmin::whereIn('id', $request->users)->delete();
        return response()->json(['success' => 'Users deleted successfully!'], 200);
    }
}
