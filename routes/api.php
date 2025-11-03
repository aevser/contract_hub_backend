<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1;

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        // Список контрагентов
        Route::get('counterparties', [V1\CounterpartyController::class, 'index'])->name('counterparties.index');

        // Создание контрагента ( инн )
        Route::post('counterparty', [V1\CounterpartyController::class, 'store'])->name('counterparties.store');
    });

    // Регистрация
    Route::post('registration', [V1\User\RegistrationController::class, 'registration'])->name('user.registration');

    // Авторизация
    Route::post('login', [V1\User\AuthController::class, 'login'])->name('user.login');
});

