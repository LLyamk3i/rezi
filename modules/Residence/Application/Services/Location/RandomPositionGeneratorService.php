<?php

declare(strict_types=1);

namespace Modules\Residence\Application\Services\Location;

use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;

final readonly class RandomPositionGeneratorService
{
    public function __construct(
        private Location $location,
        private Radius $radius,
    ) {
    }

    /**
     * @return array{latitude:float,longitude:float}
     */
    public function execute(int $precision = 4): array
    {
        $radius_in_km = $this->radius->value / Distance::LATITUDE_APPROXIMATE_LENGTH;
        $random_distance = $radius_in_km * sqrt(num: lcg_value());
        $random_angle = 2 * \M_PI * lcg_value();
        $delta_latitude = $random_distance * cos(num: $random_angle);
        $delta_longitude = $random_distance * sin(num: $random_angle) / cos(num: deg2rad(num: $this->location->latitude));

        return [
            'latitude' => round(num: $this->location->latitude + $delta_latitude, precision: $precision),
            'longitude' => round(num: $this->location->longitude + $delta_longitude, precision: $precision),
        ];
    }
}
