<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Authentication\Infrastructure\Http\Controllers;

Route::middleware('guest')->group(callback: static function (): void {
    Route::post(uri: '/register', action: Controllers\RegisterUserController::class);
    Route::post(uri: '/login', action: [Controllers\AuthenticatedSessionController::class, 'store']);
    Route::patch(uri: '/confirm/account', action: Controllers\AccountConfirmationController::class);
});

Route::middleware('auth:sanctum')->group(callback: static function (): void {
    Route::middleware('verified')->group(callback: static function (): void {
        Route::post(uri: '/upload/identity-card', action: Controllers\UploadIdentityCardController::class);
        Route::prefix('profile')->group(callback: static function (): void {
            Route::patch(uri: '/', action: [Controllers\ProfileController::class, 'update']);
        });
    });
    Route::delete(uri: '/logout', action: [Controllers\AuthenticatedSessionController::class, 'destroy']);
});
