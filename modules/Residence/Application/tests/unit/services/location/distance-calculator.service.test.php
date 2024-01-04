<?php

declare(strict_types=1);

use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Application\Services\Location\DistanceCalculatorService;

it(description: 'calculates the distance between Paris and New York', closure: function (): void {
    $paris = new Location(latitude: 48.864716, longitude: 2.349014);
    $new_york = new Location(latitude: 40.730610, longitude: -73.935242);

    $calculator = new DistanceCalculatorService();

    $distance = $calculator->execute(from: $paris, to: $new_york);

    expect(value: $distance)->toEqual(expected: 5831);
});
