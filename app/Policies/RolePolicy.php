<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view-any-role');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->can('view-role');
    }

    public function create(User $user): bool
    {
        return $user->can('create-role');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->can('update-role');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->can('delete-role');
    }

    public function restore(User $user, Role $role): bool
    {
        return false;
    }

    public function forceDelete(User $user, Role $role): bool
    {
        return false;
    }
}
