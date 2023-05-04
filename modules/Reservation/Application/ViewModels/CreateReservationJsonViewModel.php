<?php

declare(strict_types=1);

namespace Modules\Reservation\Application\ViewModels;

class CreateReservationJsonViewModel
{
    public function __construct(
        public readonly int $status,
        public readonly bool $success,
        public readonly string $message,
    ) {
    }
}
