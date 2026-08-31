<?php

namespace App\Services;

use App\Models\Permission;

class PermissionService
{
    public function getAll(int $perPage = 10, ?string $search = null)
    {
        $query = Permission::query()->orderBy('name');

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->paginate($perPage);
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
