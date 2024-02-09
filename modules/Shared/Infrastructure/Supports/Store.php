<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Supports;

use Modules\Shared\Domain\Supports\StoreContract;

final class Store implements StoreContract
{
    /**
     * @var array<string,mixed>
     */
    public array $store = [];

    public function get(string $key): mixed
    {
        $stored = $this->store[$key];
        if ($stored instanceof \Closure) {
            $this->put($key, $value = $stored($key));

            return $value;
        }

        return $stored;
    }

    public function has(string $key): bool
    {
        return isset($this->store[$key]);
    }

    public function put(string $key, mixed $value): void
    {
        $this->store[$key] = $value;
    }

    public function remember(string $key, \Closure $callback): mixed
    {
        if ($this->has($key)) {
            return $this->get($key);
        }

        $this->put($key, $result = $callback($key));

        return $result;
    }
}
