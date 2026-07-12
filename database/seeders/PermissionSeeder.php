<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = [
            'user',
            'role',
            'permission',
            'mentor',
            'menu',
        ];

        $actions = [
            'view-any',
            'view',
            'create',
            'update',
            'delete',
        ];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                $name = "{$action}-{$resource}";

                Permission::updateOrCreate(
                    ['name' => $name],
                    [
                        'guard_name' => 'web',
                        'description' => Str::headline($action) . ' ' . Str::headline($resource),
                    ]
                );
            }
        }

        // Menu permissions
        $menus = [
            'dashboard',

            'user',
            'role',
            'permission',
            'menu',

            'department',
            'skill',

            'mentor',
            'student',
            'session',

            'report',
        ];

        foreach ($menus as $menu) {
            Permission::updateOrCreate(
                [
                    'name' => "view-menu-{$menu}",
                ],
                [
                    'guard_name' => 'web',
                    'description' => 'View Menu ' . Str::headline($menu),
                ]
            );
        }
    }
}
