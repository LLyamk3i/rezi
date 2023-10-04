<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Commands;

interface VerifyReservationOwnershipContracts
{
    public function handle(): bool;
}
