<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\UseCases\CreateReservation;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Duration;

final readonly class CreateReservationRequest
{
    public function __construct(
        public Duration $stay,
        public Ulid $user,
        public Ulid $residence,
    ) {
    }
}
