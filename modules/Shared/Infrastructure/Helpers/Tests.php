<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Helpers;

use Illuminate\Support\Facades\Artisan;

function migrate_authentication(): void
{
    Artisan::call(
        command: 'migrate',
        parameters: ['--path' => 'modules/Authentication/Infrastructure/Database/Migrations']
    );
}
