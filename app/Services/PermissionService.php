<?php

namespace App\Services;

use App\Models\Permission;

class PermissionService
{
    public function getAll(int $perPage = 10)
    {
        return Permission::orderBy('name')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Permission::create($data);
    }

    public function update(Permission $permission, array $data)
    {
        $permission->update($data);

        return $permission;
    }

    public function delete(Permission $permission)
    {
        $permission->delete();
    }
}
