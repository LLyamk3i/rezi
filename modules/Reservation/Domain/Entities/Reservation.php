<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Entities;

use Modules\Reservation\Domain\Enums\Status;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Shared\Domain\ValueObjects\Duration;

final readonly class Reservation
{
    public function __construct(
        public Ulid $id,
        public Ulid $user,
        public Price $cost,
        public Duration $stay,
        public Status $status,
        public Ulid $residence,
    ) {
    }
}
