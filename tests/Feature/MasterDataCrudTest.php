<?php

namespace Tests\Feature;

use App\Models\Career;
use App\Models\Permission;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_skill_can_be_created_updated_searched_and_deleted(): void
    {
        $user = $this->userWithPermissions('skill');

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/skills', [
            'name' => 'Laravel',
            'description' => 'PHP framework',
        ]);

        $response->assertOk()->assertJsonPath('data.name', 'Laravel');
        $skill = Skill::where('name', 'Laravel')->firstOrFail();

        $this->actingAs($user, 'sanctum')->putJson('/api/skills/' . $skill->uuid, [
            'name' => 'Laravel 13',
        ])->assertOk()->assertJsonPath('data.name', 'Laravel 13');

        $this->actingAs($user, 'sanctum')->getJson('/api/skills?search=Laravel')
            ->assertOk()->assertJsonFragment(['name' => 'Laravel 13']);

        $this->actingAs($user, 'sanctum')->deleteJson('/api/skills/' . $skill->uuid)
            ->assertNoContent();
    }

    public function test_career_can_be_created_and_searched_by_code(): void
    {
        $user = $this->userWithPermissions('career');

        $createResponse = $this->actingAs($user, 'sanctum')->postJson('/api/careers', [
            'code' => 'PRODUCT_MANAGER',
            'name' => 'Product Manager',
            'order' => 1,
        ])->assertOk()->assertJsonPath('data.code', 'PRODUCT_MANAGER');

        $career = Career::where('code', 'PRODUCT_MANAGER')->firstOrFail();

        $this->actingAs($user, 'sanctum')->putJson('/api/careers/' . $career->uuid, [
            'name' => 'Senior Product Manager',
        ])->assertOk()->assertJsonPath('data.name', 'Senior Product Manager');

        $this->actingAs($user, 'sanctum')->getJson('/api/careers?search=PRODUCT_MANAGER')
            ->assertOk()->assertJsonFragment(['name' => 'Senior Product Manager']);
    }

    private function userWithPermissions(string $resource): User
    {
        $user = User::factory()->create();
        $permissions = collect(['view-any', 'view', 'create', 'update', 'delete'])
            ->map(fn (string $action) => "{$action}-{$resource}")
            ->all();

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $user->givePermissionTo($permissions);

        return $user;
    }
}