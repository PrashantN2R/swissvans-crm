<?php

namespace App\Http\Controllers\Superadmin\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
        $filter           = [];
        $filter['name']   = $request->name;

        $roles            = Role::query();
        $roles            = isset($filter['name']) ? $roles->where("name", 'LIKE', '%' . $filter['name'] . '%') : $roles;
        $roles            = $roles->orderBy('id', 'desc')->paginate(20);

        return view('superadmin.user-management.roles.list', compact('roles', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('superadmin.user-management.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'        => ['required', 'string', 'max:255', 'unique:roles'],
            'permission'  => ['required', 'array', 'min:1'],
        ]);

        $role          = Role::create(['name' => $request->name, 'guard_name' => 'superadmin']);

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('superadmin.roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find($id);
        return view('superadmin.user-management.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role        = Role::find($id);
        $permissions = Permission::get();
        return view('superadmin.user-management.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'        => ['required', 'string', 'max:255', 'unique:roles,name,' . $id],
            'permission' => ['required', 'array', 'min:1'],
        ]);

        Role::find($id)->update(['name' => $request->name, 'guard_name' => 'superadmin']);

        $role             = Role::find($id);

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('superadmin.roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::find($id)->delete();
        return redirect()->route('superadmin.roles.index')->with('success', 'Role deleted successfully!');
    }
}
