<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Services;

use Modules\Shared\Domain\ValueObjects\Price;

class CalculateReservationCostService
{
    public function execute(\DateTime $start, \DateTime $end, Price $price): Price
    {
        $days = $end->diff(targetObject: $start)->days;

        return new Price(
            value: \is_int(value: $days) ? $days * $price->value : 0,
        );
    }
}
