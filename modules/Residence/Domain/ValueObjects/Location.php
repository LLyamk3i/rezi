<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\ValueObjects;

final class Location implements \Stringable
{
    /**
     * @param float $latitude  value in radiant
     * @param float $longitude value in radiant
     */
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }

    public function __toString(): string
    {
        return $this->latitude . ' ' . $this->longitude;
    }

    /**
     * @return array{longitude:float,latitude:float}
     */
    public function __serialize(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
