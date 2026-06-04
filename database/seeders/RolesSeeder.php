<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'auditor', 'guard_name' => 'web']);
        $panelRole = Role::firstOrCreate(['name' => 'panel_user', 'guard_name' => 'web']);

        $permissions = [
            'View:Role',
            'ViewAny:Role',
            'Create:Role',
            'Update:Role',
        ];

        $permissionModels = collect($permissions)->map(function ($name) {
            return Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        });

        $superAdminRole->givePermissionTo($permissionModels);

    }
}
