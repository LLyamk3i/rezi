<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Reservation\Infrastructure\Http\Controllers;

Route::post(uri: '/', action: [Controllers\CreateervationController::class, 'store']);
