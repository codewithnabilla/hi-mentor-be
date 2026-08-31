<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;

class RoleService
{
    public function getAll(int $perPage = 10)
    {
        return Role::with('permissions')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function create(array $data)
    {
        return Role::create($data);
    }

    public function update(Role $role, array $data)
    {
        $role->update($data);

        return $role->fresh()->load('permissions');
    }

    public function delete(Role $role)
    {
        $role->delete();
    }

    public function assignPermissions(Role $role, array $permissionUuids)
    {
        $permissionIds = Permission::whereIn('uuid', $permissionUuids)
            ->pluck('id')
            ->all();

        $role->syncPermissions($permissionIds);

        return $role->fresh()->load('permissions');
    }
}
