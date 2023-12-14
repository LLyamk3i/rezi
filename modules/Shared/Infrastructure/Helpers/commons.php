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

/**
 * @template T
 *
 * @phpstan-param T $array
 *
 * @phpstan-return T
 */
function array_filter_nulls(array $array): array
{
    return array_filter(
        array: $array,
        callback: static fn (mixed $value) => ! \is_null(value: $value),
    );
}
