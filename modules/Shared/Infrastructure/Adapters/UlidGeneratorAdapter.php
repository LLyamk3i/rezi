<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Adapters;

use Symfony\Component\Uid\Ulid;
use Modules\Shared\Domain\Adapters\UlidGeneratorAdapterContract;

final class UlidGeneratorAdapter implements UlidGeneratorAdapterContract
{
    public function generate(): string
    {
        return Ulid::generate();
    }

    public function isValid(string $ulid): bool
    {
        return Ulid::isValid(ulid: $ulid);
    }
}
