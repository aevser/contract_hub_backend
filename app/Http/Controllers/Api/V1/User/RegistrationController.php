<?php

namespace App\Http\Controllers\Api\V1\User;

use App\DTO\User\CreateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\CreateUserRequest;
use App\Repositories\User\UserRepositories;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="Contract Hub API",
 *     version="1.0.0"
 * )
 * @OA\Server(url="http://localhost:8000/api/v1")
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer"
 * )
 */

class RegistrationController extends Controller
{
    use ApiResponse;

    public function __construct(private UserRepositories $userRepositories){}

    /**
     * @OA\Post(
     *     path="/registration",
     *     tags={"Authentication"},
     *     summary="Регистрация пользователя",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password", "password_confirmation"},
     *             @OA\Property(property="lastname", type="string", nullable=true, example="Иванов"),
     *             @OA\Property(property="name", type="string", nullable=true, example="Иван"),
     *             @OA\Property(property="patronymic", type="string", nullable=true, example="Иванович"),
     *             @OA\Property(property="email", type="string", example="1@1.ru"),
     *             @OA\Property(property="password", type="string", example="12345678"),
     *             @OA\Property(property="password_confirmation", type="string", example="12345678")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Успешная регистрация"),
     *     @OA\Response(response=422, description="Ошибка валидации")
     * )
     */

    public function registration(CreateUserRequest $request): JsonResponse
    {
        $dto = CreateUserDTO::fromRequest(validated: $request->validated());

        $user = $this->userRepositories->create(DTO: $dto);

        return $this->success(success: true, message: 'Пользователь успешно зарегистрирован.', data: $user, code: JsonResponse::HTTP_CREATED);
    }
}
