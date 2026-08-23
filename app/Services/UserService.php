<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getAll(int $perPage = 10)
    {
        return User::orderBy('name')->paginate($perPage);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);

        return $user;
    }

    public function delete(User $user)
    {
        $user->delete();
    }
}
