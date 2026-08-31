<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(array $data): array
    {
        $user = User::with('roles.permissions')
            ->where('email', $data['email'])
            ->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new \Exception('Invalid credentials', 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'message' => 'Login successful',
            'token' => $token,
            'user' => new UserResource($user),
        ];
    }

    public function register(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if (!empty($data['role'])) {
            $role = Role::where('name', $data['role'])->first();

            if ($role) {
                $user->syncRoles([$role->id]);
            }
        }

        $user->load('roles.permissions');

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'message' => 'Registration successful',
            'token' => $token,
            'user' => new UserResource($user),
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }

    public function me(User $user): UserResource
    {
        return new UserResource(
            $user->load('roles.permissions')
        );
    }
}
