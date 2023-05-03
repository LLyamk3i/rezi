<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Residence\Infrastructure\Http\Controllers;

Route::get(uri: '/nearest', action: [Controllers\NearestResidencesController::class, 'index']);
