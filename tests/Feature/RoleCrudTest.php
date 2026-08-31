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

    public function test_admin_can_create_and_update_user_with_multiple_roles(): void
    {
        $admin = User::factory()->create();
        Permission::firstOrCreate(['name' => 'create-user', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'update-user', 'guard_name' => 'web']);
        $admin->givePermissionTo(['create-user', 'update-user']);

        $mentorRole = Role::create([
            'name' => 'Mentor',
            'guard_name' => 'web',
            'description' => 'Mentor role',
        ]);

        $studentRole = Role::create([
            'name' => 'Student',
            'guard_name' => 'web',
            'description' => 'Student role',
        ]);

        $createResponse = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/users', [
                'name' => 'Jane User',
                'email' => 'jane@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'roles' => [$mentorRole->uuid, $studentRole->uuid],
            ]);

        $createResponse->assertCreated()
            ->assertJsonPath('data.name', 'Jane User')
            ->assertJsonCount(2, 'data.roles');

        $user = User::where('email', 'jane@example.com')->firstOrFail();
        $this->assertEqualsCanonicalizing(
            [$mentorRole->id, $studentRole->id],
            $user->fresh()->roles()->pluck('id')->all()
        );

        $updateResponse = $this->actingAs($admin, 'sanctum')
            ->putJson('/api/users/' . $user->uuid, [
                'name' => 'Jane Updated',
                'email' => 'jane.updated@example.com',
                'roles' => [$studentRole->uuid],
            ]);

        $updateResponse->assertOk()
            ->assertJsonPath('data.name', 'Jane Updated')
            ->assertJsonCount(1, 'data.roles');

        $this->assertEqualsCanonicalizing(
            [$studentRole->id],
            $user->fresh()->roles()->pluck('id')->all()
        );
    }
}
