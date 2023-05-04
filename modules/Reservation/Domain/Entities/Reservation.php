<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Entities;

use Modules\Reservation\Domain\Enums\Status;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;

final class Reservation
{
    public function __construct(
        public readonly \DateTime $checkin,
        public readonly \DateTime $checkout,
        public readonly Ulid $user,
        public readonly Ulid $residence,
        public readonly Price $cost,
        public readonly Status $status,
    ) {

    }
}
