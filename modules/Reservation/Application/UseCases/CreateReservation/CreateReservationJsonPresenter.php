<?php

declare(strict_types=1);

namespace Modules\Reservation\Application\UseCases\CreateReservation;

use Modules\Reservation\Domain\UseCases\CreateReservation\CreateReservationResponse;
use Modules\Reservation\Domain\UseCases\CreateReservation\CreateReservationPresenterContract;

class CreateReservationJsonPresenter implements CreateReservationPresenterContract
{
    private CreateReservationJsonViewModel $view;

    public function present(CreateReservationResponse $response): void
    {
        $this->view = new CreateReservationJsonViewModel(
            status: $response->failed() ? 400 : 201,
            success: ! $response->failed(),
            message: $response->message(),
        );
    }

    public function view(): CreateReservationJsonViewModel
    {
        return $this->view;
    }
}
