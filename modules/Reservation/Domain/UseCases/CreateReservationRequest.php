<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\UseCases;

use Modules\Shared\Domain\ValueObjects\Ulid;

final class CreateReservationRequest
{
    public function __construct(
        public readonly \DateTime $checkin,
        public readonly \DateTime $checkout,
        public readonly Ulid $user,
        public readonly Ulid $residence,
    ) {

    }
}
