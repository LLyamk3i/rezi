<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Repositories;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Reservation\Domain\Entities\Reservation;
use Modules\Shared\Domain\DataTransferObjects\PaginatedObject;
use Modules\Reservation\Domain\Contracts\ReservationExistsQueryContract;

interface ReservationRepository
{
    public function save(Reservation $entity): bool;
        /**
     * @return array<int,mixed>
     */
    public function history(Ulid $owner): array;
    public function exists(ReservationExistsQueryContract $checker): bool;
}
