<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Entity;

use Modules\Shared\Domain\ValueObjects\Ulid;

final class Customer
{
    public function __construct(
        public readonly Ulid $id,
        public readonly string $name,
    ) {
    }
}
