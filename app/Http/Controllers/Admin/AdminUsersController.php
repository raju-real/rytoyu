<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUsersController extends Controller
{
    public function index()
    {
        $admins = \App\Models\Admin::whereIn('type', ['administrator', 'admin'])->get();
        return view('admin.admin_users.index', compact('admins'));
    }

    public function create()
    {
        $roles = \App\Models\Role::all();
        return view('admin.admin_users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6',
            'role_id' => 'required',
        ]);

        \App\Models\Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password_plain' => $request->password,
            'password' => bcrypt($request->password),
            'type' => $request->role_id == 'administrator' ? 'administrator' : 'admin',
            'role_id' => $request->role_id == 'administrator' ? null : $request->role_id,
            'code' => \App\Models\Admin::getCode(),
            'status' => 'active',
            'request_status' => 'approved'
        ]);

        return redirect()->route('admin.admin-users.index')->with(['type' => 'success', 'message' => 'Admin User created successfully.']);
    }

    public function edit($id)
    {
        $admin = \App\Models\Admin::findOrFail($id);
        $roles = \App\Models\Role::all();
        return view('admin.admin_users.edit', compact('admin', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $admin = \App\Models\Admin::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role_id' => 'required',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        if ($request->password) {
            $admin->password_plain = $request->password;
            $admin->password = bcrypt($request->password);
        }
        $admin->type = $request->role_id == 'administrator' ? 'administrator' : 'admin';
        $admin->role_id = $request->role_id == 'administrator' ? null : $request->role_id;
        $admin->save();

        return redirect()->route('admin.admin-users.index')->with(['type' => 'success', 'message' => 'Admin User updated successfully.']);
    }

    public function destroy($id)
    {
        $admin = \App\Models\Admin::findOrFail($id);
        if ($admin->id == Auth::guard('admin')->id()) {
            return redirect()->back()->with(['type' => 'error', 'message' => 'You cannot delete yourself.']);
        }
        if ($admin->type == 'administrator' && \App\Models\Admin::where('type', 'administrator')->count() == 1) {
            return redirect()->back()->with(['type' => 'error', 'message' => 'Cannot delete the only administrator.']);
        }

        $admin->delete();
        return redirect()->route('admin.admin-users.index')->with(['type' => 'success', 'message' => 'Admin User deleted successfully.']);
    }
}
