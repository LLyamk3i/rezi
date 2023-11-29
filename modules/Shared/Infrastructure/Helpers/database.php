<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Helpers;

function using_sqlite(): bool
{
    return config(key: 'database.default') === 'sqlite';
}

function can_use_spatial_index(): bool
{
    return ! using_sqlite();
}
