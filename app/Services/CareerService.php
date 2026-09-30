<?php

namespace App\Services;

use App\Models\Career;

class CareerService
{
    public function getAll(int $perPage = 10, ?string $search = null)
    {
        $query = Career::query()->orderBy('order')->orderBy('name');

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'ilike', "%{$search}%")
                    ->orWhere('code', 'ilike', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function create(array $data): Career
    {
        return Career::create($data);
    }

    public function update(Career $career, array $data): Career
    {
        $career->update($data);
        return $career;
    }

    public function delete(Career $career): void
    {
        $career->delete();
    }
}