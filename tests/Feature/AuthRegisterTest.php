<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_receive_token(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertCreated()
            ->assertJsonPath('user.email', 'john@example.com')
            ->assertJsonPath('user.name', 'John Doe')
            ->assertJsonStructure([
                'message',
                'token',
                'user' => ['uuid', 'name', 'email', 'roles'],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
        ]);

        $this->assertTrue(User::where('email', 'john@example.com')->exists());
    }

    public function test_user_can_register_with_only_mentor_or_student_role(): void
    {
        Role::firstOrCreate([
            'name' => 'Mentor',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Student',
            'guard_name' => 'web',
        ]);

        $this->postJson('/api/register', [
            'name' => 'Mentor User',
            'email' => 'mentor@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'Mentor',
        ])->assertCreated();

        $this->assertDatabaseHas('model_has_roles', [
            'model_type' => User::class,
            'model_id' => User::where('email', 'mentor@example.com')->value('id'),
        ]);

        $user = User::where('email', 'mentor@example.com')->firstOrFail();
        $this->assertSame(['Mentor'], $user->fresh()->getRoleNames()->all());

        $this->postJson('/api/register', [
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'Student',
        ])->assertCreated();

        $student = User::where('email', 'student@example.com')->firstOrFail();
        $this->assertSame(['Student'], $student->fresh()->getRoleNames()->all());
    }
}
