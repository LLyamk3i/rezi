<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;

/**
 * @phpstan-type ResidenceFormat array{id:string,name:string,address:string,description:string,distance:string,location:Location,rent:array{value:float,format:string}}
 */
final readonly class Residence
{
    public function __construct(
        public Ulid $id,
        public string $name,
        public string $address,
        public string $description,
        public Distance $distance,
        public Location $location,
        public Price $rent,
        public Owner | null $owner = null,
        public string | null $poster = null
    ) {
        //
    }

    /**
     * @phpstan-return ResidenceFormat
     */
    public function __serialize(): array
    {
        return [
            'id' => $this->id->value,
            'name' => $this->name,
            'address' => $this->address,
            'description' => $this->description,
            'distance' => (string) $this->distance,
            'location' => $this->location,
            'poster' => $this->poster,
            'owner' => [
                'id' => $this->owner?->id->value,
                'name' => $this->owner?->name,
            ],
            'rent' => [
                'value' => $this->rent->value,
                'format' => number_format(num: $this->rent->value, thousands_separator: ' ') . ' ' . Price::CURRENCY,
            ],
        ];
    }
}
