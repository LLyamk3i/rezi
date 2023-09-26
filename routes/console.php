<?php

declare(strict_types=1);

use Illuminate\Console\Command;

use Illuminate\Foundation\Inspiring;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

use function Laravel\Prompts\note;

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
    note(message: Inspiring::quote());
})->purpose(description: 'Display an inspiring quote');

Artisan::command(signature: 'admin:build', callback: function (): int {
    $result = Process::path(path: __DIR__ . '/../modules/Admin/resources/frontend')->run(command: 'pnpm run build');
    note(message: $result->output());

    return Command::SUCCESS;
});
