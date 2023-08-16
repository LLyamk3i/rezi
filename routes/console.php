<?php

declare(strict_types=1);

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

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
    $this->comment(string: Inspiring::quote());
})->purpose(description: 'Display an inspiring quote');

Artisan::command(signature: 'app:setup', callback: function (): int {
    Artisan::call(command: 'migrate:fresh');
    // exec(command: 'unlink ./public/dist');
    // Artisan::call(command: 'admin:build');
    // exec(command: 'ln -s $(readlink -f ./modules/Admin/resources/frontend/build) $(readlink -f ./public/dist)');
    app(abstract: \Modules\Auth\Infrastructure\Database\Seeders\RoleTableSeeder::class)->run();
    app(abstract: \Modules\Admin\Infrastructure\Database\Seeders\AdminSeeder::class)->run();
    app(abstract: \Modules\Auth\Infrastructure\Database\Seeders\ProviderSeeder::class)->run();
    app(abstract: \Modules\Residence\Infrastructure\Database\Seeders\TypeSeeder::class)->run();

    return Command::SUCCESS;
})->purpose(description: 'Set up the application');

Artisan::command(signature: 'admin:build', callback: function (): int {
    $result = Process::path(path: __DIR__ . '/../modules/Admin/resources/frontend')->run(command: 'pnpm run build');
    $this->line(string: $result->output());

    return Command::SUCCESS;
});
