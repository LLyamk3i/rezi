<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Adapters;

use Illuminate\Cache\CacheManager;
use Modules\Shared\Domain\Adapters\CacheAdapterContract;

final readonly class CacheAdapter implements CacheAdapterContract
{
    public function __construct(
        private CacheManager $cache,
    ) {
        //
    }

    public function put(string $key, mixed $value): void
    {
        $this->cache->put($key, $value);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function get(string $key): mixed
    {
        return $this->cache->get($key);
    }
}
