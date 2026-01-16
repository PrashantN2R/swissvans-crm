<?php

namespace App\Http\Controllers\Superadmin\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
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

        $permissions            = Permission::query();
        $permissions            = isset($filter['name']) ? $permissions->where("name", 'LIKE', '%' . $filter['name'] . '%') : $permissions;
        $permissions            = $permissions->orderBy('id', 'desc')->paginate(20);

        return view('superadmin.user-management.permissions.list', compact('permissions', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::get();
        return view('superadmin.user-management.permissions.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data             = $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:permissions'],
            'role'        => ['array'],
        ]);

        $permission       = Permission::create($data);

        $permission->syncRoles($request->input('role'));

        return redirect()->route('superadmin.permissions.index')->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $roles      = Role::get();
        $permission = Permission::find($id);
        return view('superadmin.user-management.permissions.show', compact('permission', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles      = Role::get();
        $permission = Permission::find($id);
        return view('superadmin.user-management.permissions.edit', compact('permission', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data             = $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:permissions,name,' . $id],
            'role'       => ['array'],
        ]);

        Permission::find($id)->update(['name' => $request->name]);

        $permission = Permission::find($id);

        $permission->syncRoles($request->input('role'));

        return redirect()->route('superadmin.permissions.index')->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Permission::find($id)->delete();
        return redirect()->route('superadmin.permissions.index')->with('success', 'Permission deleted successfully!');
    }
}
