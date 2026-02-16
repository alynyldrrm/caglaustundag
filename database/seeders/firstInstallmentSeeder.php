<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class firstInstallmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "admin",
            "email" => "admin@devayazilim.com.tr",
            "password" => Hash::make("123456"),
            "phone" => null,
        ]);
        Language::create(["key" => "tr", "text" => "Türkçe", "is_default" => true]);
        WebsiteSetting::create();
        Role::create(["name" => "Administrator"]);
        Permission::create(['name' => 'Dil Yönetimi']);
        Permission::create(['name' => 'Tip Yönetimi']);
        Permission::create(['name' => 'Kullanıcı Yönetimi']);
        Permission::create(['name' => 'Çeviri Yönetimi']);
        Permission::create(['name' => 'İçerik Yönetimi']);
        Permission::create(['name' => 'Rol Yönetimi']);
        Permission::create(['name' => 'Form Yönetimi']);
        Permission::create(['name' => 'Menü Yönetimi']);
        DB::table('role_has_permissions')->insert(['permission_id' => '1', 'role_id' => '1',]);
        DB::table('role_has_permissions')->insert(['permission_id' => '2', 'role_id' => '1',]);
        DB::table('role_has_permissions')->insert(['permission_id' => '3', 'role_id' => '1',]);
        DB::table('role_has_permissions')->insert(['permission_id' => '4', 'role_id' => '1',]);
        DB::table('role_has_permissions')->insert(['permission_id' => '5', 'role_id' => '1',]);
        DB::table('role_has_permissions')->insert(['permission_id' => '6', 'role_id' => '1',]);
        DB::table('role_has_permissions')->insert(['permission_id' => '7', 'role_id' => '1',]);
        DB::table('role_has_permissions')->insert(['permission_id' => '8', 'role_id' => '1',]);
        DB::table('model_has_roles')->insert(['role_id' => '1', 'model_type' => 'App\Models\User', 'model_id' => '1']);
    }
}
