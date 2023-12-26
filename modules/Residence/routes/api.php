<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Residence\Infrastructure\Http\Controllers;

Route::get(uri: '/', action: [Controllers\ResidenceController::class, 'index']);
Route::get(uri: '/{residence}', action: [Controllers\ResidenceController::class, 'show'])->where(name: 'residence', expression: '[0123456789ABCDEFGHJKMNPQRSTVWXYZ]{26}');
Route::get(uri: '/nearest', action: Controllers\NearestResidencesController::class);
Route::match(methods: ['get', 'post'], uri: '/search', action: Controllers\SearchResidencesController::class);

Route::get(uri: '/types', action: [Controllers\TypeController::class, 'index']);
Route::get(uri: '/features', action: [Controllers\FeatureController::class, 'index']);
Route::post(uri: '/views', action: [Controllers\ViewController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(callback: static function (): void {
    Route::post(uri: '/ratings', action: [Controllers\RatingController::class, 'store']);
    Route::resource(name: 'favorites', controller: Controllers\FavoriteController::class)->only(methods: ['index', 'store', 'destroy']);
});
