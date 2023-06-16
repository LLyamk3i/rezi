<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Helpers;

/**
 * @param array<string,string|int> $queries
 */
function route(string $path, array $queries): string
{
    return $path . '?' . http_build_query($queries);
}
