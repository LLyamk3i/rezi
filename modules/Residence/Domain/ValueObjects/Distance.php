<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\ValueObjects;

final readonly class Distance implements \Stringable
{
    public const EARTH_RADIUS = 6371;

    public const EARTH_LATITUDE_APPROXIMATE_LENGTH = 111.3; // 111.3 km is the approximate length of 1 degree of latitude in kilometers

    public function __construct(
        public float $value,
        public string $unit = 'km',
    ) {
        if ($value < 0) {
            throw new \InvalidArgumentException(message: 'Value must be a non-negative number');
        }

        if (! \in_array(needle: $unit, haystack: ['km', 'mi'], strict: true)) {
            throw new \InvalidArgumentException(message: 'Invalid unit provided.');
        }
    }

    public function __toString(): string
    {
        return $this->value . ' ' . $this->unit;
    }

    public function convert(string $unit): self
    {
        if ($unit === $this->unit) {
            return $this;
        }

        if ($unit === 'km') {
            return new self(value: $this->value * 1.609344, unit: $unit);
        }

        if ($unit === 'mi') {
            return new self(value: $this->value * 0.621371192, unit: $unit);
        }

        throw new \InvalidArgumentException(message: 'Invalid unit provided.');
    }
}
