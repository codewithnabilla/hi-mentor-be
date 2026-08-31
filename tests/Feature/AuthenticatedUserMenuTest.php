<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticatedUserMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_list_contains_only_menus_allowed_for_the_user(): void
    {
        $user = User::factory()->create();
        Permission::create([
            'name' => 'view-menu-users',
            'guard_name' => 'web',
        ]);
        $user->givePermissionTo('view-menu-users');

        $group = Menu::create([
            'name' => 'User Management',
            'route' => '/user-management',
            'order' => 1,
        ]);
        Menu::create([
            'name' => 'Users',
            'route' => '/users',
            'parent_uuid' => $group->uuid,
            'permission' => 'view-menu-users',
            'order' => 1,
        ]);
        Menu::create([
            'name' => 'Roles',
            'route' => '/roles',
            'permission' => 'view-menu-roles',
            'order' => 2,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/menus');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'User Management')
            ->assertJsonPath('data.0.children.0.name', 'Users');
    }

    public function test_me_returns_authenticated_user_roles_and_permissions(): void
    {
        $user = User::factory()->create([
            'name' => 'Signed In User',
        ]);
        Permission::create([
            'name' => 'view-menu-dashboard',
            'guard_name' => 'web',
        ]);
        $user->givePermissionTo('view-menu-dashboard');

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/me')
            ->assertOk()
            ->assertJsonPath('user.name', 'Signed In User')
            ->assertJsonPath('user.email', $user->email)
            ->assertJsonPath('user.permissions.0.name', 'view-menu-dashboard');
    }
}