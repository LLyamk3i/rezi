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
        public Duration $stay,
        public Ulid $user,
        public Ulid $residence,
        public Price $cost,
        public Status $status,
    ) {
    }
}
