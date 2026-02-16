<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Town;
use App\Models\User;
use App\Models\Uye;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        $roles = Role::all();
        return view('admin.users.create', compact('roles', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'numeric', 'unique:users,phone'],
            'role' => ['required', 'numeric'],
            'password' => ['required', 'min:6', 'max:32'],
        ]);
        $role = Role::where('id', $request->role)->first();
        if (!$role) {
            return redirect()->back()->withErrors(['Rol bulunamadı!']);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'identity_number' => $request->identity_number,
            'job' => $request->job,
            'blood_group' => $request->blood_group,
            'gender' => $request->gender,
            'education_status' => $request->education_status,
            'city_id' => $request->city_id,
            'town_id' => $request->town_id,
            'role' => $request->role,
            'address' => $request->address,
            'type' => 'admin',
            'password' => Hash::make($request->password),
        ]);
        $user->syncRoles($request->role);
        return redirect()->route('admin.user.index')->with('success', 'Kullanıcı başarıyla eklendi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id = 0)
    {
        $user = User::find($id);
        if (!$user && $user->type != "admin") {
            return redirect()->route('admin.user.index')->withErrors(["Kullanıcı Bulunamadı!"]);
        }
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id = 0)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $id . ''],
            'phone' => ['required', 'numeric', 'unique:users,phone,' . $id . ''],
            'role' => ['required', 'numeric'],
            'password' => ['nullable', 'min:6', 'max:32'],
        ]);
        $roles = Role::where('id', $request->role)->first();
        if (!$roles) {
            return redirect()->back()->withErrors(['Rol bulunamadı!']);
        }
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->withErrors(['Kullanıcı bulunamadı!']);
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'type' => 'admin',
        ]);
        if ($request->password != null) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        $user->syncRoles($request->role);
        return redirect()->route('admin.user.index')->with('success', 'Kullanıcı başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id = 0)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.user.index')->withErrors(["Kullanıcı Bulunamadı!"]);
        }
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', "Kullanıcı başarıyla silindi.");
    }
}
