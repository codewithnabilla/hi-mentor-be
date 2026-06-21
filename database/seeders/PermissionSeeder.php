<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            // User
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'delete_user',

            // Role
            'view_any_role',
            'view_role',
            'create_role',
            'update_role',
            'delete_role',

            // Permission
            'view_any_permission',
            'view_permission',
            'create_permission',
            'update_permission',
            'delete_permission',

            // Mentor
            'view_any_mentor',
            'view_mentor',
            'create_mentor',
            'update_mentor',
            'delete_mentor',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission],
                [
                    'name' => $permission,
                    'description' => ucwords(str_replace('_', ' ', $permission)),
                ]
            );
        }
    }
}
