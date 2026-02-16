<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    function index()
    {
        $roles = Role::withCount('users')->get();
        return view('admin.permissions.index', compact('roles'));
    }
    function store(Request $request)
    {
        $request->validate([
            'role' => ['required', 'unique:roles,name']
        ]);
        Role::create(['name' => $request->role]);
        return redirect()->route('admin.permissions.index')->with('success', 'Rol başarıyla eklendi');
    }

    function edit($id = 0)
    {
        $role = Role::where('id', $id)
            ->with('permissions')
            ->first();
        if (!$role) {
            return redirect()->route('admin.permissions.index')->withErrors(["Rol bulunamadı!"]);
        }
        $permissions = Permission::all();
        return view('admin.permissions.edit', compact('role', 'permissions'));
    }

    function update($id = 0, Request $request)
    {
        $role = Role::find($id);
        if (!$role) {
            return redirect()->route('admin.permissions.index')->withErrors(["Rol bulunamadı!"]);
        }
        $permissions = [];
        $request = $request->all();
        unset($request['_token']);
        foreach ($request as $key => $value) {
            array_push($permissions, $key);
        }
        $role->syncPermissions($permissions);
        return redirect()->route('admin.permissions.index')->with('success', 'Güncelleme işlemi başarılı.');
    }
    function destroy($id = 0)
    {
        $role = Role::withCount('users')->where('id', $id)->first();
        if (!$role) {
            return redirect()->route('admin.permissions.index')->withErrors(["Rol bulunamadı!"]);
        }
        if ($role->users_count != 0) {
            return redirect()->route('admin.permissions.index')->withErrors(["Kallanıcısı olan bir rolü silemezsiniz!"]);
        }
        DB::table('role_has_permissions')->where('role_id', $role->id)->delete();
        $role->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Silme işlemi başarılı');
    }
}
