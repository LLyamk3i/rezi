<?php

declare(strict_types=1);

use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Reservation\Domain\Services\CalculateReservationCostService;
use Modules\Shared\Domain\ValueObjects\Duration;

uses(\Tests\TestCase::class);

it(description: 'should calculate residences nights cost', closure: function (): void {
    $calculator = new CalculateReservationCostService();
    $cost = $calculator->execute(
        price: new Price(value: 15_000),
        duration: new Duration(
            start: new \DateTime(datetime: now()->toDateString()),
            end: new \DateTime(datetime: now()->addDays(value: 25)->toDateString()),
        ),
    );

    expect(value: $cost)->toBeInstanceOf(class: Price::class);
    expect(value: $cost->value)->toEqual(expected: 375_000);
});
