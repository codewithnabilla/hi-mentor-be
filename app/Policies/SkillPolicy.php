<?php

namespace App\Policies;

use App\Models\Skill;
use App\Models\User;

class SkillPolicy
{
    public function viewAny(User $user): bool { return $user->can('view-any-skill'); }
    public function view(User $user, Skill $skill): bool { return $user->can('view-skill'); }
    public function create(User $user): bool { return $user->can('create-skill'); }
    public function update(User $user, Skill $skill): bool { return $user->can('update-skill'); }
    public function delete(User $user, Skill $skill): bool { return $user->can('delete-skill'); }
}