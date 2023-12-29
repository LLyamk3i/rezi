<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;

/**
 * @phpstan-type ResidenceFormat array{id:string,name:string,view:int,favoured:bool,address:string,description:string,distance:string,location:Location,poster?:string,rent:array{value:float,format:string},owner?:array{id:string,name:string}}
 */
final readonly class Residence
{
    /**
     * @param array<int,string>|null                                           $gallery
     * @param array<int,\Modules\Residence\Domain\Entities\Feature>|null       $features
     * @param array<int,\Modules\Residence\Domain\Entities\Rating>|null        $ratings
     * @param array<int,\Modules\Reservation\Domain\Entities\Reservation>|null $reservations
     */
    public function __construct(
        public Ulid $id,
        public int $view,
        public Price $rent,
        public string $name,
        public string $address,
        public Distance $distance,
        public Location $location,
        public bool $favoured = false,
        public int | null $rooms = null,
        public Type | null $type = null,
        public float | null $note = null,
        public Owner | null $owner = null,
        public array | null $ratings = null,
        public string | null $poster = null,
        public array | null $gallery = null,
        public array | null $features = null,
        public string | null $residence = null,
        public array | null $reservations = null,
        public string | null $description = null,
    ) {
        //
    }

    /**
     * @phpstan-return ResidenceFormat
     */
    public function __serialize(): array
    {
        return [
            'name' => $this->name,
            'rooms' => $this->rooms,
            'view' => $this->view,
            'id' => $this->id->value,
            'poster' => $this->poster,
            'address' => $this->address,
            'favoured' => $this->favoured,
            'note' => $this->note,
            'description' => $this->description,
            'type' => $this->type?->__serialize(),
            'distance' => (string) $this->distance,
            'location' => $this->location->__serialize(),
            'gallery' => $this->gallery,
            'rent' => [
                'value' => $this->rent->value,
                'format' => number_format(num: $this->rent->value, thousands_separator: ' ') . ' ' . Price::CURRENCY,
            ],
        ];
    }
}
