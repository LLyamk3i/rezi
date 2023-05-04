<?php

declare(strict_types=1);

use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Reservation\Domain\Services\CalculateReservationCostService;

uses(\Tests\TestCase::class);

it(description: 'should calculate residences nights cost', closure: function (): void {
    $calculator = new CalculateReservationCostService();
    $cost = $calculator->execute(
        start: new \DateTime(datetime: now()->toDateString()),
        end: new \DateTime(datetime: now()->addDays(value: 25)->toDateString()),
        price: new Price(value: 15_000)
    );

    expect(value: $cost)->toBeInstanceOf(class: Price::class);
    expect(value: $cost->value)->toEqual(expected: 375_000);
});
