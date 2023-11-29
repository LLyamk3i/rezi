<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Utils;

use Modules\Shared\Domain\Adapters\CacheAdapterContract;

use function Modules\Shared\Infrastructure\Helpers\integer_value;

final class Timer
{
    private int $counter;

    public function __construct(
        private readonly CacheAdapterContract $cache,
        private readonly string $key,
    ) {
        //
    }

    public function start(int $counter): void
    {
        $this->counter = $counter;
        $this->cache->put(key: $this->key, value: $counter);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function value(): int
    {
        return integer_value(value: $this->cache->get(key: $this->key));
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function loop(): int
    {
        return $this->counter - $this->value();
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function decrease(): int
    {
        $count = $this->value();
        $this->cache->put(key: $this->key, value: --$count);

        return $count;
    }
}
