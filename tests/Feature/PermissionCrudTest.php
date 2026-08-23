<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_permission(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/permissions', [
                'name' => 'view permissions',
                'guard_name' => 'web',
                'description' => 'Can view permissions',
            ]);

        $response->assertCreated()
            ->assertJsonPath('data.name', 'view permissions')
            ->assertJsonPath('data.description', 'Can view permissions');

        $this->assertDatabaseHas('permissions', [
            'name' => 'view permissions',
            'guard_name' => 'web',
        ]);
    }
}
