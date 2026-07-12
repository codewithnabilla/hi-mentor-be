<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'description' => 'Full system access',
            ],
            [
                'name' => 'Admin',
                'description' => 'Administrative access',
            ],
            [
                'name' => 'Mentor',
                'description' => 'Mentor access',
            ],
            [
                'name' => 'Student',
                'description' => 'Student access',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                [
                    'name' => $role['name'],
                ],
                [
                    'guard_name' => 'web',
                    'description' => $role['description'],
                ]
            );
        }

        // Super Admin
        Role::findByName('Super Admin')
            ->syncPermissions(Permission::all());

        // Admin
        Role::findByName('Admin')
            ->syncPermissions([
                'view-menu-dashboard',

                'view-menu-user',
                'view-menu-role',
                'view-menu-permission',
                'view-menu-menu',

                'view-any-user',
                'view-user',
                'create-user',
                'update-user',

                'view-any-role',
                'view-role',

                'view-any-permission',
                'view-permission',

                'view-any-menu',
                'view-menu',
                'create-menu',
                'update-menu',
            ]);

        // Mentor
        Role::findByName('Mentor')
            ->syncPermissions([
                'view-menu-dashboard',

                'view-menu-mentor',
                'view-menu-session',

                'view-any-mentor',
                'view-mentor',
            ]);

        // Student
        Role::findByName('Student')
            ->syncPermissions([
                'view-menu-dashboard',
            ]);
    }
}
