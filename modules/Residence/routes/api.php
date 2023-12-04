<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Residence\Infrastructure\Http\Controllers;

Route::get(uri: '/', action: [Controllers\ResidenceController::class, 'index']);
Route::get(uri: '/nearest', action: Controllers\NearestResidencesController::class);
Route::get(uri: '/search', action: Controllers\SearchResidencesController::class);

Route::get(uri: '/types', action: [Controllers\TypeController::class, 'index']);
Route::get(uri: '/features', action: [Controllers\FeatureController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(callback: static function (): void {
    Route::resource(name: 'favorites', controller: Controllers\FavoriteResidenceController::class)
        ->only(methods: ['index', 'store', 'destroy']);
});
