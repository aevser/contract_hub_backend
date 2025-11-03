<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepositories
{
    public function __construct(private User $user){}

    public function create(array $data): User
    {
        return $this->user->query()->create($data);
    }
}
