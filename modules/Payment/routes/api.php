<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Payment\Infrastructure\Http\Controllers;

Route::middleware(['auth:sanctum', 'verified'])->group(callback: static function (): void {
    Route::post(uri: '/', action: [Controllers\PaymentController::class, 'store']);
});
