<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Payment\Infrastructure\Http\Controllers\PaymentController;
use Modules\Payment\Infrastructure\Http\Middleware\RejectUnownedPaymentMiddleware;

Route::middleware(['auth:sanctum', 'verified'])->controller(PaymentController::class)->group(callback: static function (): void {
    Route::post(uri: '/', action: 'store');
    Route::patch(uri: '/{payment}', action: 'update')->middleware(RejectUnownedPaymentMiddleware::class);
});
