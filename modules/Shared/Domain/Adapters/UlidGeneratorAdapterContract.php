<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Adapters;

interface UlidGeneratorAdapterContract
{
    public function generate(): string;

    public function isValid(string $ulid): bool;
}
