<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command(signature: 'inspire', callback: function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command(signature: 'app:setup', callback: function (): void {
    Artisan::call(command: 'migrate:fresh');
    app(abstract: \Modules\Auth\Infrastructure\Database\Seeders\RoleTableSeeder::class)->run();
    app(abstract: \Modules\Admin\Infrastructure\Database\Seeders\AdminSeeder::class)->run();
    exec(command: 'unlink ./public/dist');
    exec(command: 'ln -s $(readlink -f ./modules/Admin/resources/frontend/build) $(readlink -f ./public/dist)');
})->purpose('Set up the application');
