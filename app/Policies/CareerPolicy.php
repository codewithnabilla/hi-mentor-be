<?php

namespace App\Policies;

use App\Models\Career;
use App\Models\User;

class CareerPolicy
{
    public function viewAny(User $user): bool { return $user->can('view-any-career'); }
    public function view(User $user, Career $career): bool { return $user->can('view-career'); }
    public function create(User $user): bool { return $user->can('create-career'); }
    public function update(User $user, Career $career): bool { return $user->can('update-career'); }
    public function delete(User $user, Career $career): bool { return $user->can('delete-career'); }
}