<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\CreateUserRequest;
use App\Repositories\User\UserRepositories;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class RegistrationController extends Controller
{
    use ApiResponse;

    public function __construct(private UserRepositories $userRepositories){}

    public function registration(CreateUserRequest $request): JsonResponse
    {
        $user = $this->userRepositories->create($request->validated());

        return $this->success(success: true, message: 'Пользователь успешно зарегестрирован.', data: $user, code: JsonResponse::HTTP_CREATED);
    }
}
