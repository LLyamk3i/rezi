<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Factories;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Residence\Domain\Entities\Residence;
use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;

/**
 * @phpstan-type ResidenceRecord array{id:string,note?:float,name:string,rent?:float,poster?:string,address:string,distance?:float,latitude?:float,longitude?:float,description?:string,gallery?:array<int,string>,type?:\Modules\Residence\Domain\Entities\Type,owner?:\Modules\Residence\Domain\Entities\Owner,ratings?:array<int,\Modules\Residence\Domain\Entities\Rating>,features?:array<int,\Modules\Residence\Domain\Entities\Feature>,reservations?:array<int,\Modules\Reservation\Domain\Entities\Reservation>}
 */
final class ResidenceFactory
{
    /**
     * @phpstan-param ResidenceRecord $data
     *
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     * @throws \InvalidArgumentException
     */
    public function make(array $data): Residence
    {
        return new Residence(
            name: $data['name'],
            address: $data['address'],
            note: $data['note'] ?? null,
            type: $data['type'] ?? null,
            owner: $data['owner'] ?? null,
            poster: $data['poster'] ?? null,
            id: new Ulid(value: $data['id']),
            gallery: $data['gallery'] ?? null,
            ratings: $data['ratings'] ?? null,
            features: $data['features'] ?? null,
            description: $data['description'] ?? null,
            rent: new Price(value: $data['rent'] ?? 0),
            reservations: $data['reservations'] ?? null,
            distance: new Distance(value: $data['distance'] ?? 0),
            location: new Location(latitude: $data['latitude'] ?? 0, longitude: $data['longitude'] ?? 0),
        );
    }
}
