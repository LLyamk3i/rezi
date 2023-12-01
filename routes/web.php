<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::redirect(uri: '/', destination: '/api');
Route::get(uri: '/images/{path}', action: [App\Http\Controllers\ImageController::class, 'show'])
    ->where(name: 'path', expression: '.*')->name(name: 'image.show');
