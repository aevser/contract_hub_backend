<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1;

Route::prefix('v1')->group(function () {
    Route::post('registration', [V1\User\RegistrationController::class, 'registration']);

    Route::post('login', [V1\User\AuthController::class, 'login']);
});

