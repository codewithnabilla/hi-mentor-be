<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dashboard = Menu::create([
            'name' => 'Dashboard',
            'route' => '/dashboard',
            'icon' => 'Dashboard',
            'order' => 1,
            'permission' => 'view-menu-dashboard',
        ]);

        $userManagement = Menu::create([
            'name' => 'User Management',
            'route' => '/user-management',
            'icon' => 'People',
            'order' => 2,
        ]);

        Menu::create([
            'name' => 'Users',
            'route' => '/users',
            'icon' => 'Person',
            'parent_uuid' => $userManagement->uuid,
            'order' => 1,
            'permission' => 'view-menu-user',
        ]);

        Menu::create([
            'name' => 'Roles',
            'route' => '/roles',
            'icon' => 'AdminPanelSettings',
            'parent_uuid' => $userManagement->uuid,
            'order' => 2,
            'permission' => 'view-menu-role',
        ]);

        Menu::create([
            'name' => 'Menus',
            'route' => '/menus',
            'icon' => 'Menu',
            'parent_uuid' => $userManagement->uuid,
            'order' => 3,
            'permission' => 'view-menu-menu',
        ]);

        $master = Menu::create([
            'name' => 'Master Data',
            'route' => '/master',
            'icon' => 'Folder',
            'order' => 3,
        ]);

        Menu::create([
            'name' => 'Departments',
            'route' => '/departments',
            'parent_uuid' => $master->uuid,
            'icon' => 'Business',
            'order' => 1,
            'permission' => 'view-menu-department',
        ]);

        Menu::create([
            'name' => 'Skills',
            'route' => '/skills',
            'parent_uuid' => $master->uuid,
            'icon' => 'School',
            'order' => 2,
            'permission' => 'view-menu-skill',
        ]);

        $mentor = Menu::create([
            'name' => 'Mentoring',
            'route' => '/mentoring',
            'icon' => 'Groups',
            'order' => 4,
        ]);

        Menu::create([
            'name' => 'Mentors',
            'route' => '/mentors',
            'parent_uuid' => $mentor->uuid,
            'icon' => 'Person',
            'order' => 1,
            'permission' => 'view-menu-mentor',
        ]);

        Menu::create([
            'name' => 'Students',
            'route' => '/students',
            'parent_uuid' => $mentor->uuid,
            'icon' => 'School',
            'order' => 2,
            'permission' => 'view-menu-student',
        ]);

        Menu::create([
            'name' => 'Sessions',
            'route' => '/sessions',
            'parent_uuid' => $mentor->uuid,
            'icon' => 'CalendarMonth',
            'order' => 3,
            'permission' => 'view-menu-session',
        ]);

        Menu::create([
            'name' => 'Reports',
            'route' => '/reports',
            'icon' => 'Assessment',
            'order' => 5,
            'permission' => 'view-menu-report',
        ]);
    }
}
