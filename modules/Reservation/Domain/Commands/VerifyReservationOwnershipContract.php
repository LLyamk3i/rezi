<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Commands;

interface VerifyReservationOwnershipContract
{
    public function handle(): bool;
}
