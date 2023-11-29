<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Residence\Infrastructure\Http\Controllers;

Route::get(uri: '/', action: [Controllers\ResidenceController::class, 'index']);
Route::get(uri: '/nearest', action: Controllers\NearestResidencesController::class);
Route::get(uri: '/search', action: Controllers\SearchResidencesController::class);
