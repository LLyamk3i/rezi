<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Adapters;

interface CacheAdapterContract
{
    public function put(string $key, mixed $value): void;

    public function get(string $key): mixed;
}
