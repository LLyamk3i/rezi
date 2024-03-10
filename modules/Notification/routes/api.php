<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Notification\Infrastructure\Http\Controllers;

Route::middleware(['auth:sanctum', 'verified'])->group(callback: static function (): void {
    Route::get(uri: '/', action: [Controllers\UserNotificationsController::class, 'index']);
    Route::prefix('reads')->group(callback: static function (): void {
        Route::delete(uri: '/', action: [Controllers\ReadNotificationsController::class, 'destroy']);
        Route::delete(uri: '/{notification}', action: [Controllers\ReadNotificationController::class, 'destroy']);
    });
});
