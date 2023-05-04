<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Contracts;

use Modules\Reservation\Domain\UseCases\CreateReservationResponse;

interface CreateReservationPresenterContract
{
    public function present(CreateReservationResponse $response): void;
}
