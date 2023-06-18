<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Reservation\Domain\Repositories\ReservationRepository;
use Modules\Reservation\Infrastructure\Http\Requests\VerifyReservationAvailabilityRequest;

final class VerifyReservationAvailabilityController
{
    public function __invoke(VerifyReservationAvailabilityRequest $request, ReservationRepository $repository): JsonResponse
    {
        $data = $request->approved();
        $exists = $repository->exists(stay: $data['stay'], residence: $data['residence']);

        return response()->json(
            status: $exists ? 200 : 404,
            data: [
                'success' => $exists,
                'message' => $exists ? 'La réservation exist.' : "La réservation n'exit pas.",
            ],
        );
    }
}
