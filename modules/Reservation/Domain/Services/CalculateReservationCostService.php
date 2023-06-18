<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Services;

use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Shared\Domain\ValueObjects\Duration;

final class CalculateReservationCostService
{
    public function execute(Duration $duration, Price $price): Price
    {
        return new Price(value: $duration->length() * $price->value);
    }
}
