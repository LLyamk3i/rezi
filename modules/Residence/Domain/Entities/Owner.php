<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;

final readonly class Owner
{
    public function __construct(
        public Ulid $id,
        public string $name,
    ) {
    }
}
