<?php

declare(strict_types=1);

namespace Modules\Reservation\Application\Commands;

use Modules\Reservation\Domain\Repositories\ReservationRepository;
use Modules\Reservation\Domain\Contracts\ReservationExistsQueryContract;
use Modules\Reservation\Domain\Commands\VerifyReservationOwnershipContract;

final readonly class VerifyReservationOwnership implements VerifyReservationOwnershipContract
{
    public function __construct(
        private ReservationRepository $repository,
        private ReservationExistsQueryContract $query,
    ) {
        //
    }

    public function handle(): bool
    {
        return $this->repository->exists(checker: $this->query);
    }
}
