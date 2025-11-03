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

    public function login(AuthRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->validated())) {
            return $this->message(success: false, message: 'Введены неверные данные.', code: JsonResponse::HTTP_UNAUTHORIZED);
        }

        $user = auth()->user();

        $token = $user->createToken(self::API_TOKEN)->plainTextToken;

        return $this->auth(success: true, user: $user, token: $token, code: JsonResponse::HTTP_OK);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->message(success: true, message: 'Успешно вышли из системы.', code: JsonResponse::HTTP_OK);
    }
}
