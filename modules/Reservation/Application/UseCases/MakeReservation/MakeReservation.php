<?php

declare(strict_types=1);

namespace Modules\Reservation\Application\UseCases\MakeReservation;

use Modules\Shared\Domain\Enums\Http;
use Modules\Reservation\Domain\Enums\Status;
use Modules\Shared\Domain\UseCases\Response;
use Modules\Shared\Domain\ValueObjects\Price;
use Illuminate\Contracts\Translation\Translator;
use Modules\Reservation\Domain\Entities\Reservation;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Reservation\Domain\Repositories\ReservationRepository;
use Modules\Shared\Application\UseCases\InternalServerErrorResponse;
use Modules\Reservation\Domain\Services\CalculateReservationCostService;
use Modules\Reservation\Domain\UseCases\MakeReservation\MakeReservationRequest;
use Modules\Reservation\Domain\UseCases\MakeReservation\MakeReservationContract;

use function Modules\Shared\Infrastructure\Helpers\ulid;
use function Modules\Shared\Infrastructure\Helpers\string_value;

final readonly class MakeReservation implements MakeReservationContract
{
    public function __construct(
        private Translator $translator,
        private ResidenceRepository $residences,
        private InternalServerErrorResponse $error,
        private ReservationRepository $reservations,
        private CalculateReservationCostService $calculator,
    ) {
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function execute(MakeReservationRequest $request): Response
    {
        try {
            $rent = $this->residences->rent(id: $request->residence);
        } catch (\Throwable $throwable) {
            return $this->error->handle(throwable: $throwable);
        }

        if (\is_null(value: $rent)) {
            return new Response(
                failed: true,
                status: Http::BAD_REQUEST,
                message: string_value(value: $this->translator->get(
                    key: 'reservation::messages.make.errors.residence',
                    replace: ['id' => $request->residence->value]
                )),
            );
        }

        $reservation = new Reservation(
            id: ulid(),
            stay: $request->stay,
            owner: $request->user,
            residence: $request->residence,
            cost: $this->cost(request: $request, rent: $rent),
            status: Status::PENDING,
        );

        try {
            $this->reservations->save(entity: $reservation);
        } catch (\Throwable $throwable) {
            return $this->error->handle(throwable: $throwable);
        }

        return new Response(
            failed: false,
            status: Http::CREATED,
            data: ['reservation_id' => $reservation->id->value],
            message: string_value(value: $this->translator->get(key: 'reservation::messages.make.success')),
        );
    }

    /**
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    private function cost(MakeReservationRequest $request, Price $rent): Price
    {
        return $this->calculator->execute(duration: $request->stay, price: $rent);
    }
}
