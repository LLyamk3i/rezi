<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;

use function Modules\Shared\Infrastructure\Helpers\array_filter_filled;

/**
 * @phpstan-type ResidenceFormat array{id:string,name:string,address:string,description:string,distance:string,location:Location,poster?:string,rent:array{value:float,format:string},owner?:array{id:string,name:string}}
 */
final readonly class Residence
{
    /**
     * @param array<int,string>    |null                                       $gallery
     * @param array<int,\Modules\Residence\Domain\Entities\Feature> |null      $features
     * @param array<int,\Modules\Residence\Domain\Entities\Rating>|null        $ratings
     * @param array<int,\Modules\Reservation\Domain\Entities\Reservation>|null $reservations
     */
    public function __construct(
        public Ulid $id,
        public Price $rent,
        public string $name,
        public string $address,
        public Distance $distance,
        public Location $location,
        public Type | null $type = null,
        public float | null $note = null,
        public Owner | null $owner = null,
        public array | null $ratings = null,
        public string | null $poster = null,
        public array | null $gallery = null,
        public array | null $features = null,
        public array | null $reservations = null,
        public string | null $description = null,
        public string | null $residence = null,
    ) {
        //
    }

    /**
     * @phpstan-return ResidenceFormat
     */
    public function __serialize(): array
    {
        return array_filter_filled(array: [
            'id' => $this->id->value,
            'name' => $this->name,
            'address' => $this->address,
            'description' => $this->description,
            'distance' => (string) $this->distance,
            'location' => $this->location,
            'poster' => $this->poster,
            'type' => $this->type?->__serialize(),
            'rent' => [
                'value' => $this->rent->value,
                'format' => number_format(num: $this->rent->value, thousands_separator: ' ') . ' ' . Price::CURRENCY,
            ],
        ]);
    }
}
