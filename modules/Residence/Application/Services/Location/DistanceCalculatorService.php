<?php

declare(strict_types=1);

namespace Modules\Residence\Application\Services\Location;

use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;

class DistanceCalculatorService
{
    public function execute(Location $from, Location $to): int
    {
        // Conversion des latitudes et longitudes en radians
        $from = [
            'latitude' => deg2rad(num: $from->latitude),
            'longitude' => deg2rad(num: $from->longitude),
        ];
        $to = [
            'latitude' => deg2rad(num: $to->latitude),
            'longitude' => deg2rad(num: $to->longitude),
        ];

        // Calcul des différences de latitude et de longitude
        $difference = [
            'latitude' => $to['latitude'] - $from['latitude'],
            'longitude' => $to['longitude'] - $from['longitude'],
        ];

        // Calcul de la distance en kilomètres
        $pow = [
            'latitude' => sin(num: $difference['latitude'] / 2) ** 2,
            'longitude' => sin(num: $difference['longitude'] / 2) ** 2,
        ];

        $distance = 2 * Distance::EARTH_RADIUS * $this->asin(
            pow: $pow,
            latitudes: ['to' => $to['latitude'], 'from' => $from['latitude']]
        );

        return (int) ceil(num: $distance);
    }

    /**
     * @param array{latitude:float,longitude:float} $pow
     * @param array{from:float,to:float}            $latitudes
     */
    private function asin(array $pow, array $latitudes): float
    {
        return asin(num: $this->sqrt(pow: $pow, latitudes: $latitudes));
    }

    /**
     * @param array{latitude:float,longitude:float} $pow
     * @param array{from:float,to:float}            $latitudes
     */
    private function sqrt(array $pow, array $latitudes): float
    {
        return sqrt(num: $this->part(pow: $pow, latitudes: $latitudes));
    }

    /**
     * @param array{latitude:float,longitude:float} $pow
     * @param array{from:float,to:float}            $latitudes
     */
    private function part(array $pow, array $latitudes): float
    {
        return $pow['latitude'] + cos(num: $latitudes['from']) * cos(num: $latitudes['to']) * $pow['longitude'];
    }
}
