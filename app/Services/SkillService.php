<?php

namespace App\Services;

use App\Models\Skill;

class SkillService
{
    public function getAll(int $perPage = 10, ?string $search = null)
    {
        $query = Skill::query()->orderBy('name');

        if ($search) {
            $query->where('name', 'ilike', "%{$search}%");
        }

        return $query->paginate($perPage);
    }

    public function create(array $data): Skill
    {
        return Skill::create($data);
    }

    public function update(Skill $skill, array $data): Skill
    {
        $skill->update($data);
        return $skill;
    }

    public function delete(Skill $skill): void
    {
        $skill->delete();
    }
}