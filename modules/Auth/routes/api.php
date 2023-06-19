<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Infrastructure\Http\Controllers;

Route::middleware('guest')->group(callback: static function (): void {
    Route::post(uri: '/register', action: Controllers\RegisterUserController::class);
    Route::post(uri: '/login', action: [Controllers\AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(callback: static function (): void {
    Route::delete(uri: '/logout', action: [Controllers\AuthenticatedSessionController::class, 'destroy']);
});
