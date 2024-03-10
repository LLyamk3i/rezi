<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Adapters;

use Illuminate\Support\Facades\Cache;
use Modules\Shared\Domain\Adapters\CacheAdapterContract;

final readonly class CacheAdapter implements CacheAdapterContract
{
    public function put(string $key, mixed $value): void
    {
        Cache::put(key: $key, value: $value);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function get(string $key): mixed
    {
        return Cache::get(key: $key);
    }
}
