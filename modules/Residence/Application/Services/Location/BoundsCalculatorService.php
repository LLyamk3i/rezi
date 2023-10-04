<?php

declare(strict_types=1);

namespace Modules\Residence\Application\Services\Location;

use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;

final class BoundsCalculatorService
{
    /**
     * @return array{max_latitude:float,min_latitude:float,max_longitude:float,min_longitude:float}
     */
    public function execute(Location $location, Radius $radius): array
    {
        return [
            'max_latitude' => $location->latitude + rad2deg(num: $radius->value / Distance::EARTH_RADIUS),
            'min_latitude' => $location->latitude - rad2deg(num: $radius->value / Distance::EARTH_RADIUS),
            'max_longitude' => $this->longitude(location: $location, radius: $radius, extremity: 'max'),
            'min_longitude' => $this->longitude(location: $location, radius: $radius, extremity: 'min'),
        ];
    }

    private function longitude(Location $location, Radius $radius, string $extremity): float
    {
        $asin = asin(num: $radius->value / Distance::EARTH_RADIUS);
        $cos = cos(num: deg2rad(num: $location->latitude));

        if ($extremity === 'min') {
            return $location->longitude - rad2deg(num: $asin / $cos);
        }

        if ($extremity === 'max') {
            return $location->longitude + rad2deg(num: $asin / $cos);
        }

        throw new \InvalidArgumentException(message: sprintf(
            'Expected parameter value "min" or "max", "%s" given',
            $extremity
        ));
    }
}
