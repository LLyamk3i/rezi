<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\UseCases\CreateReservation;

interface CreateReservationContract
{
    public function execute(CreateReservationRequest $request, CreateReservationPresenterContract $presenter): void;
}
