<?php

declare(strict_types=1);

namespace Modules\Reservation\Application\UseCases\CreateReservation;

use Modules\Reservation\Domain\Enums\Status;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Reservation\Domain\Entities\Reservation;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Reservation\Domain\Repositories\ReservationRepository;
use Modules\Reservation\Domain\Services\CalculateReservationCostService;
use Modules\Reservation\Domain\UseCases\CreateReservation\CreateReservationRequest;
use Modules\Reservation\Domain\UseCases\CreateReservation\CreateReservationContract;
use Modules\Reservation\Domain\UseCases\CreateReservation\CreateReservationResponse;
use Modules\Reservation\Domain\UseCases\CreateReservation\CreateReservationPresenterContract;

class CreateReservation implements CreateReservationContract
{
    public function __construct(
        private readonly ReservationRepository $reservationRepository,
        private readonly ResidenceRepository $residenceRepository,
        private readonly CalculateReservationCostService $calculator,
        private readonly CreateReservationResponse $response,
    ) {
    }

    public function execute(CreateReservationRequest $request, CreateReservationPresenterContract $presenter): void
    {
        $residence = $this->residenceRepository->find(id: $request->residence);

        if (\is_null(value: $residence)) {
            $this->response->setFailed(value: true);
            $this->response->setMessage(value: 'résidence non trouvée');
        } else {
            $this->reservationRepository->save(entity: new Reservation(
                checkin: $request->checkin,
                checkout: $request->checkout,
                user: $request->user,
                residence: $request->residence,
                cost: $this->cost(request: $request, rent: $residence->rent),
                status: Status::PENDING,
            ));
            $this->response->setFailed(value: false);
            $this->response->setMessage(value: 'La réservation a été créée avec succès.');
        }

        $presenter->present(response: $this->response);
    }

    private function cost(CreateReservationRequest $request, Price $rent): Price
    {
        return $this->calculator->execute(
            start: $request->checkin,
            end: $request->checkout,
            price: $rent
        );
    }
}
