<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Contracts;

interface ReservationExistsQueryContract
{
    public function run(): bool;
}
