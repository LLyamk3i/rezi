<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Reservation\Domain\UseCases\CreateReservationContract;
use Modules\Reservation\Infrastructure\Http\Requests\ReservationRequest;
use Modules\Reservation\Application\Presenters\CreateReservationJsonPresenter;

class ReservationController
{
    public function store(
        ReservationRequest $request,
        CreateReservationContract $useCase,
        CreateReservationJsonPresenter $presenter
    ): JsonResponse {
        $useCase->execute(request: $request->approved(), presenter: $presenter);
        $json = $presenter->view();

        return response()->json(
            status: $json->status,
            data: [
                'success' => $json->success,
                'message' => $json->message,
            ],
        );
    }
}
