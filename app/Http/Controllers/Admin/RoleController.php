<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public static $permissions = [
        'manage_products' => 'Manage Products',
        'manage_orders' => 'Manage Orders',
        'manage_webpage' => 'Manage Web Page Sections',
        'manage_attributes' => 'Manage Attributes',
        'manage_sellers' => 'Manage Sellers & Payouts',
        'manage_refunds' => 'Manage Refunds',
        'manage_coupons' => 'Manage Coupons',
        'manage_settings' => 'Manage Settings',
        'manage_admins' => 'Manage Admins & Roles',
        'manage_reports' => 'Manage Reports',
    ];

    public function index()
    {
        $roles = \App\Models\Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = self::$permissions;
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array'
        ]);

        \App\Models\Role::create([
            'name' => $request->name,
            'permissions' => $request->permissions ?? []
        ]);

        return redirect()->route('admin.roles.index')->with(['type' => 'success', 'message' => 'Role created successfully.']);
    }

    public function edit(\App\Models\Role $role)
    {
        $permissions = self::$permissions;
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, \App\Models\Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array'
        ]);

        $role->update([
            'name' => $request->name,
            'permissions' => $request->permissions ?? []
        ]);

        return redirect()->route('admin.roles.index')->with(['type' => 'success', 'message' => 'Role updated successfully.']);
    }

    public function destroy(\App\Models\Role $role)
    {
        if ($role->admins()->count() > 0) {
            return redirect()->back()->with(['type' => 'error', 'message' => 'Role is assigned to admins and cannot be deleted.']);
        }

        $role->delete();
        return redirect()->route('admin.roles.index')->with(['type' => 'success', 'message' => 'Role deleted successfully.']);
    }
}
