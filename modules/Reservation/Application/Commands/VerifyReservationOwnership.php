<?php

declare(strict_types=1);

namespace Modules\Reservation\Application\Commands;

use Modules\Reservation\Domain\Repositories\ReservationRepository;
use Modules\Reservation\Domain\Commands\VerifyReservationOwnershipContracts;
use Modules\Reservation\Domain\Contracts\ReservationVerificationQueryContract;

final readonly class VerifyReservationOwnership implements VerifyReservationOwnershipContracts
{
    public function __construct(
        private ReservationRepository $repository,
        private ReservationVerificationQueryContract $query,
    ) {
        //
    }

    public function handle(): bool
    {
        return $this->repository->exists(checker: $this->query);
    }
}
