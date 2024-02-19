<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Factories;

use Modules\Residence\Domain\Entities\Owner;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Residence\Domain\Entities\Residence;
use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;

use function Modules\Shared\Infrastructure\Helpers\array_pull_and_exclude;

/**
 * @phpstan-type ResidenceRecord array{id:string,name:string,rooms:int,address:string,view?:int,note?:float,favoured?:bool,rent?:float,poster?:string,distance?:float,latitude?:float,longitude?:float,description?:string,gallery?:array<int,string>,type?:\Modules\Residence\Domain\Entities\Type,owner?:\Modules\Residence\Domain\Entities\Owner,ratings?:array<int,\Modules\Residence\Domain\Entities\Rating>,features?:array<int,\Modules\Residence\Domain\Entities\Feature>,reservations?:array<int,\Modules\Reservation\Domain\Entities\Reservation>}
 */
final class ResidenceFactory
{
    public function __construct(
        private readonly OwnerFactory $owner,
    ) {
        //
    }

    /**
     * @phpstan-param ResidenceRecord $data
     *
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     * @throws \InvalidArgumentException
     */
    public function make(array $data): Residence
    {
        return new Residence(
            id: new Ulid(value: $data['id']),
            name: $data['name'],
            rooms: $data['rooms'],
            view: $data['view'] ?? null,
            address: $data['address'],
            note: $data['note'] ?? null,
            type: $data['type'] ?? null,
            owner: $this->owner(data: $data),
            poster: $data['poster'] ?? null,
            gallery: $data['gallery'] ?? null,
            ratings: $data['ratings'] ?? null,
            features: $data['features'] ?? null,
            favoured: $data['favoured'] ?? false,
            description: $data['description'] ?? null,
            rent: new Price(value: $data['rent'] ?? 0),
            reservations: $data['reservations'] ?? null,
            distance: new Distance(value: $data['distance'] ?? 0),
            location: new Location(latitude: $data['latitude'] ?? 0, longitude: $data['longitude'] ?? 0),
        );
    }

    /**
     * @param array<string,string> $data
     *
     * @throws \InvalidArgumentException
     */
    private function owner(array $data): Owner | null
    {
        $owner_data = array_pull_and_exclude(original: $data, keys: ['owner_id', 'owner_forename', 'owner_surname', 'owner_avatar']);

        if ($owner_data === []) {
            return null;
        }

        return $this->owner->make(data: $owner_data);
    }
}
