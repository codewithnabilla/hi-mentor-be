<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;

class UserService
{
    public function getAll(int $perPage = 10, ?string $search = null)
    {
        $query = User::with('roles')->orderBy('name');

        if (!empty($search)) {
            $query->where('name', 'ilike', '%' . $search . '%');
        }

        return $query->paginate($perPage);
    }

    public function create(array $data)
    {
        $roles = $data['roles'] ?? null;
        unset($data['roles']);

        $user = User::create($data);

        if ($roles !== null) {
            $roleIds = Role::whereIn('uuid', $roles)->pluck('id')->all();
            $user->syncRoles($roleIds);
        }

        return $user->fresh()->load('roles');
    }

    public function update(User $user, array $data)
    {
        $roles = $data['roles'] ?? null;
        unset($data['roles']);

        $user->update($data);

        if ($roles !== null) {
            $roleIds = Role::whereIn('uuid', $roles)->pluck('id')->all();
            $user->syncRoles($roleIds);
        }

        return $user->fresh()->load('roles');
    }

    public function delete(User $user)
    {
        $user->delete();
    }
}
