<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Infrastructure\Http\Controllers\RegisterUserController;

Route::middleware('guest')->group(callback: static function (): void {
    Route::post(uri: '/register', action: RegisterUserController::class);
    // Route::post(uri: '/login', action: [Api\AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(callback: static function (): void {
    // Route::post(uri: '/logout', action: [Api\AuthenticatedSessionController::class, 'destroy']);
});
