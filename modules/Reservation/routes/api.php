<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Reservation\Infrastructure\Http\Controllers;

Route::middleware(['auth:sanctum', 'verified'])->group(callback: static function (): void {
    Route::post(uri: '/', action: [Controllers\ReservationController::class, 'store']);
    Route::get(uri: '/history/{user}', action: [Controllers\ReservationHistoryController::class, 'index']);
});
Route::get(uri: '/availability', action: Controllers\VerifyReservationAvailabilityController::class);
