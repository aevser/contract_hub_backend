<?php

namespace App\Repositories\User;

use App\DTO\User\CreateUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepositories
{
    public function __construct(private User $user){}

    public function create(CreateUserDTO $DTO): User
    {
        $data = $DTO->toArray();

        $data['password'] = Hash::make($DTO->password);

        return $this->user->query()->create($data);
    }
}
