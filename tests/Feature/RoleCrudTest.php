<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_role_and_assign_permissions(): void
    {
        $user = User::factory()->create();

        Permission::firstOrCreate([
            'name' => 'create-role',
            'guard_name' => 'web',
        ]);

        Permission::firstOrCreate([
            'name' => 'update-role',
            'guard_name' => 'web',
        ]);

        Permission::firstOrCreate([
            'name' => 'view-role',
            'guard_name' => 'web',
        ]);

        Permission::firstOrCreate([
            'name' => 'view-any-role',
            'guard_name' => 'web',
        ]);

        $user->givePermissionTo(['create-role', 'update-role', 'view-role', 'view-any-role']);

        $permissionA = Permission::create([
            'name' => 'view users',
            'guard_name' => 'web',
            'description' => 'Can view users',
        ]);

        $permissionB = Permission::create([
            'name' => 'create users',
            'guard_name' => 'web',
            'description' => 'Can create users',
        ]);

        $createResponse = $this->actingAs($user, 'sanctum')
            ->postJson('/api/roles', [
                'name' => 'Editor',
                'guard_name' => 'web',
                'description' => 'Editor access',
            ]);

        $createResponse->assertCreated()
            ->assertJsonPath('data.name', 'Editor')
            ->assertJsonPath('data.description', 'Editor access');

        $role = Role::where('name', 'Editor')->firstOrFail();

        $assignResponse = $this->actingAs($user, 'sanctum')
            ->putJson('/api/roles/' . $role->uuid . '/permissions', [
                'permissions' => [$permissionA->uuid, $permissionB->uuid],
            ]);

        $assignResponse->assertOk()
            ->assertJsonPath('data.name', 'Editor')
            ->assertJsonCount(2, 'data.permissions');

        $this->assertDatabaseHas('role_has_permissions', [
            'role_id' => $role->id,
            'permission_id' => $permissionA->id,
        ]);

        $this->assertTrue($role->fresh()->hasPermissionTo($permissionA));
    }
}
