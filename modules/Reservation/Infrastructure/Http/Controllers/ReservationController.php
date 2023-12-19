<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Http\Controllers;

use Modules\Shared\Infrastructure\Http\JsonResponse;
use Modules\Reservation\Infrastructure\Http\Requests\MakeReservationRequest;
use Modules\Reservation\Domain\UseCases\MakeReservation\MakeReservationContract;

final class ReservationController
{
    /**
     * @throws \Exception
     *
     * @see \Modules\Reservation\Application\UseCases\MakeReservation\MakeReservation
     */
    public function store(MakeReservationRequest $request, MakeReservationContract $usecase): JsonResponse
    {
        return new JsonResponse(
            response: $usecase->execute(request: $request->approved()),
        );
    }
}
