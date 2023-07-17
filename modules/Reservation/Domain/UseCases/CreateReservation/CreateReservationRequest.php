<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\UseCases\CreateReservation;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Duration;

final class CreateReservationRequest
{
    public function __construct(
        public readonly Duration $stay,
        public readonly Ulid $user,
        public readonly Ulid $residence,
    ) {
    }
}
