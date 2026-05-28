<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::findOrCreate('super_admin');
        $managerRole = Role::findOrCreate('manager');
        $userRole = Role::findOrCreate('panel_user');

        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('admin@admin.com'),
            ]
        );

        $superAdmin->assignRole($superAdminRole);

        $manager = User::firstOrCreate(
            ['email' => 'manager@manager.com'],
            [
                'name' => 'Manager',
                'password' => bcrypt('manager@manager.com'),
            ]
        );

        $manager->assignRole($managerRole);

        $user = User::firstOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'User',
                'password' => bcrypt('user@user.com'),
            ]
        );

        $user->assignRole($userRole);

    }
}
