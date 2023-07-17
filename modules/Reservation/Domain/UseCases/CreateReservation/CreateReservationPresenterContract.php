<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\UseCases\CreateReservation;

interface CreateReservationPresenterContract
{
    public function present(CreateReservationResponse $response): void;
}
