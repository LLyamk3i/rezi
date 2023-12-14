<?php

declare(strict_types=1);

use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;
use Modules\Residence\Application\Services\Location\DistanceCalculatorService;
use Modules\Residence\Application\Services\Location\RandomPositionGeneratorService;

test(description: 'Random position generator service returns valid coordinates within bounds', closure: function (): void {
    $location = new Location(latitude: 40.712776, longitude: -74.005974); // New York City coordinates
    $radius = new Radius(value: 10);
    $distanceCalculatorService = new DistanceCalculatorService();
    $randomPositionGeneratorService = new RandomPositionGeneratorService(location: $location, radius: $radius);

    for ($i = 0; $i < 10; $i++) {
        $coordinates = $randomPositionGeneratorService->execute();
        $distance = $distanceCalculatorService->execute(
            from: $location,
            to: new Location(
                latitude: $coordinates['latitude'],
                longitude: $coordinates['longitude']
            )
        );

        expect(value: $distance)->toBeLessThanOrEqual(expected: $radius->value);
        expect(value: $distance)->toBeGreaterThan(expected: 0);
    }
});
