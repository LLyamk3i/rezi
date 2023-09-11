<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Generators;

use Symfony\Component\Uid\Ulid;
use Modules\Shared\Domain\Contracts\GeneratorContract;

final class UlidGenerator implements GeneratorContract
{
    public function generate(): string
    {
        return Ulid::generate();
    }
}
