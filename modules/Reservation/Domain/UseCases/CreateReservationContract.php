<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\UseCases;

use Modules\Reservation\Domain\Contracts\CreateReservationPresenterContract;

interface CreateReservationContract
{
    public function execute(CreateReservationRequest $request, CreateReservationPresenterContract $presenter): void;
}
