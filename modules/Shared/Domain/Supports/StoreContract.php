<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Supports;

interface StoreContract
{
    public function get(string $key): mixed;

    public function has(string $key): bool;

    public function put(string $key, mixed $value): void;

    public function remember(string $key, \Closure $callback): mixed;
}
