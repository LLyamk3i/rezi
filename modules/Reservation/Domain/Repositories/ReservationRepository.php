<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Repositories;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Reservation\Domain\Entities\Reservation;

interface ReservationRepository
{
    public function save(Reservation $entity): void;

    public function exists(Duration $stay, Ulid $residence): bool;
}
