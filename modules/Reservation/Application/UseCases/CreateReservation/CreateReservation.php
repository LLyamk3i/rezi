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

final readonly class CreateReservation implements CreateReservationContract
{
    public function __construct(
        private ReservationRepository $reservationRepository,
        private ResidenceRepository $residenceRepository,
        private CalculateReservationCostService $calculator,
        private CreateReservationResponse $response,
    ) {
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function execute(CreateReservationRequest $request, CreateReservationPresenterContract $presenter): void
    {
        $residence = $this->residenceRepository->find(id: $request->residence);

        if (\is_null(value: $residence)) {
            $this->response->setFailed(value: true);
            $this->response->setMessage(value: 'résidence non trouvée');
        } else {
            $this->reservationRepository->save(entity: new Reservation(
                stay: $request->stay,
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

    /**
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    private function cost(CreateReservationRequest $request, Price $rent): Price
    {
        return $this->calculator->execute(duration: $request->stay, price: $rent);
    }
}
