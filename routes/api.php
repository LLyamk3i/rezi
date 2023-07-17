<?php

declare(strict_types=1);

use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;

Route::get(uri: '/', action: Api\WelcomeController::class);
