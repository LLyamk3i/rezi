<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Repositories;

use Modules\Reservation\Domain\Entities\Reservation;

interface ReservationRepository
{
    public function save(Reservation $entity): void;
}
