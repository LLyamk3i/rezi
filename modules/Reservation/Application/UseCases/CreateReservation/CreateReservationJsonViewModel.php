<?php

declare(strict_types=1);

namespace Modules\Reservation\Application\UseCases\CreateReservation;

final readonly class CreateReservationJsonViewModel
{
    public function __construct(
        public int $status,
        public bool $success,
        public string $message,
    ) {
    }
}
