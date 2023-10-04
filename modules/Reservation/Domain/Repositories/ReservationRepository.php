<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Repositories;

use Modules\Reservation\Domain\Entities\Reservation;
use Modules\Reservation\Domain\Contracts\ReservationVerificationQueryContract;

interface ReservationRepository
{
    public function save(Reservation $entity): void;

    public function exists(ReservationVerificationQueryContract $checker): bool;
}
