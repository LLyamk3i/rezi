<?php

declare(strict_types=1);

use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;
use Modules\Residence\Application\Services\Location\BoundsCalculatorService;

it(description: 'calculates bounds correctly', closure: function (): void {
    $service = new BoundsCalculatorService();
    $location = new Location(latitude: 48.8588377, longitude: 2.2770199);
    $radius = new Radius(value: 25);
    $bounds = $service->execute(location: $location, radius: $radius);
    expect(value: $bounds)->toBeArray();
    expect(value: $bounds)->toHaveCount(count: 4);
    expect(value: $bounds)->toHaveKeys(keys: ['max_latitude', 'min_latitude', 'max_longitude', 'min_longitude']);
    // Check the bounds values against a known test case
    expect(value: $bounds['max_latitude'])->toEqualWithDelta(expected: 49.08366810148, delta: 0.000001);
    expect(value: $bounds['min_latitude'])->toEqualWithDelta(expected: 48.63400729852, delta: 0.000001);
    expect(value: $bounds['max_longitude'])->toEqualWithDelta(expected: 2.618751709099, delta: 0.000001);
    expect(value: $bounds['min_longitude'])->toEqualWithDelta(expected: 1.935288090901, delta: 0.000001);
});
