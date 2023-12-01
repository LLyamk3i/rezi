<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\UseCases\MakeReservation;

use Modules\Shared\Domain\UseCases\Response;

interface MakeReservationContract
{
    public function execute(MakeReservationRequest $request): Response;
}
