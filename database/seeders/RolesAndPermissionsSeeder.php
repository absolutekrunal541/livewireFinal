<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = ['create tasks', 'assign tasks', 'view tasks'];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions($permissions);

        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $manager->syncPermissions(['assign tasks', 'view tasks']);

        $employee = Role::firstOrCreate(['name' => 'Employee']);
        $employee->syncPermissions(['view tasks']);

        // Assign roles to users (optional)
        $user = User::find(1);
        if ($user) {
            $user->assignRole('Admin');
        }
    }
}
