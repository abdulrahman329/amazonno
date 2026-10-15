<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    // Create permissions for Category
    Permission::firstOrCreate(['name' => 'category.create']);
    Permission::firstOrCreate(['name' => 'category.edit']);
    Permission::firstOrCreate(['name' => 'category.delete']);

    // Create permissions for User
    Permission::firstOrCreate(['name' => 'Product.create']);
    Permission::firstOrCreate(['name' => 'Product.edit']);
    Permission::firstOrCreate(['name' => 'Product.delete']);


    $adminRole = Role::firstOrCreate(['name' => 'admin']);

    $adminRole->syncPermissions(Permission::all());



    $userRole = Role::firstOrCreate(['name' => 'user']);

    $userRole->syncPermissions([
        'Product.create',
        'Product.edit',
        'Product.delete',
    ]);



    $admin = User::firstOrCreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Admin',
            'password' => Hash::make('12345678'),
            ]
    );

    $admin->syncRoles(['admin']);

    }
}
