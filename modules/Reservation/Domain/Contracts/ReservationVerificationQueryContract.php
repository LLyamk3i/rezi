<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Contracts;

interface ReservationVerificationQueryContract
{
    public function run(): bool;
}
