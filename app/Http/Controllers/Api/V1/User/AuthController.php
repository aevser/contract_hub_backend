<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\AuthRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    private const string API_TOKEN = '';

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Authentication"},
     *     summary="Авторизация пользователя",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="1@1.ru"),
     *             @OA\Property(property="password", type="string", example="12345678")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Успешная авторизация"),
     *     @OA\Response(response=401, description="Неверные данные")
     * )
     */

    public function login(AuthRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->validated())) {
            return $this->message(success: false, message: __('responses.user.unauthorized'), code: JsonResponse::HTTP_UNAUTHORIZED);
        }

        $user = auth()->user();

        $token = $user->createToken(self::API_TOKEN)->plainTextToken;

        return $this->auth(success: true, user: $user, token: $token, code: JsonResponse::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"Authentication"},
     *     summary="Выход из системы",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Успешный выход"),
     *     @OA\Response(response=401, description="Неавторизован")
     * )
     */

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->message(success: true, message: __('responses.user.logout'), code: JsonResponse::HTTP_OK);
    }
}
