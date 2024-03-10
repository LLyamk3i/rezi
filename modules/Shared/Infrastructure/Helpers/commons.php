<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Helpers;

/**
 * @param array<string,string|int> $queries
 */
function route(string $path, array $queries): string
{
    return $path . '?' . http_build_query(data: $queries);
}

/**
 * @template T
 *
 * @phpstan-param array<T|null> $array
 *
 * @phpstan-return array<T>
 */
function array_filter_filled(array $array): array
{
    return array_filter(
        array: $array,
        callback: static fn (mixed $value): bool => filled(value: $value),
    );
}

/**
 * @template K
 * @template V
 *
 * @phpstan-param array<K,V> $original
 *
 * @param array<int,string> $keys
 *
 * @phpstan-return array<K,V>
 */
function array_pull_and_exclude(array &$original, array $keys): array
{
    $result = [];
    foreach ($keys as $key) {
        if (\array_key_exists(key: $key, array: $original)) {
            $result[$key] = $original[$key];
            unset($original[$key]);
        }
    }

    return array_filter_filled(array: $result);
}
