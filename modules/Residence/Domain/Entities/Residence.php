<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;

/**
 * @phpstan-type ResidenceFormat array{id:string,name:string,address:string,description:string,distance:string,location:Location,rent:array{value:float,format:string,currency:string}}
 */
final class Residence
{
    public function __construct(
        public readonly Ulid $id,
        public readonly string $name,
        public readonly string $address,
        public readonly string $description,
        public readonly Distance $distance,
        public readonly Location $location,
        public readonly Price $rent,
        // public readonly Owner $owner,
    ) {
    }

    /**
     * @return ResidenceFormat
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
            'rent' => [
                'value' => $this->rent->value,
                'format' => number_format(num: $this->rent->value, thousands_separator: ' '),
                'currency' => Price::CURRENCY,
            ],
        ];
    }
}
