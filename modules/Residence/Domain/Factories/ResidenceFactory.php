<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Factories;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Residence\Domain\Entities\Residence;
use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;

/**
 * @phpstan-type ResidenceRecord array{id:string,name:string,address:string,description?:string,distance?:float,latitude?:float,longitude?:float,rent?:float}
 */
final class ResidenceFactory
{
    /**
     * @phpstan-param ResidenceRecord $data
     */
    public function make(array $data): Residence
    {
        return new Residence(
            id: new Ulid(value: $data['id']),
            name: $data['name'],
            address: $data['address'],
            description: $data['description'] ?? '',
            distance: new Distance(value: $data['distance'] ?? 0),
            location: new Location(latitude: $data['latitude'] ?? 0, longitude: $data['longitude'] ?? 0),
            rent: new Price(value: $data['rent'] ?? 0)
        );
    }
}
