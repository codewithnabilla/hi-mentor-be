<?php

namespace App\Services;
use App\Models\Department;

class DepartmentService
{
    public function getAll(int $perPage = 10, ?string $search = null)
    {
        $query = Department::query()->orderBy('name');

        if ($search) {
            $query->where('name', 'ilike', "%{$search}%");
        }

        return $query->paginate($perPage);
    }

    public function create(array $data)
    {
        return Department::create($data);
    }

    public function update(Department $department, array $data)
    {
        $department->update($data);

        return $department;
    }

    public function delete(Department $department)
    {
        $department->delete();
    }
}