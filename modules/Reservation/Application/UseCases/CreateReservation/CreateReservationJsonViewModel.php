<?php

declare(strict_types=1);

namespace Modules\Reservation\Application\UseCases\CreateReservation;

final class CreateReservationJsonViewModel
{
    public function __construct(
        public readonly int $status,
        public readonly bool $success,
        public readonly string $message,
    ) {
    }
}
