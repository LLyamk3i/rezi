<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\ValueObjects;

use InvalidArgumentException;

final class Distance implements \Stringable
{
    public const EARTH_RADIUS = 6371;

    public const LATITUDE_APPROXIMATE_LENGTH = 111.3; // 111.3 km is the approximate length of 1 degree of latitude in kilometers

    public function __construct(
        public readonly float $value,
        public readonly string $unit = 'km',
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException(message: 'Value must be a non-negative number');
        }

        if (! \in_array(needle: $unit, haystack: ['km', 'mi'], strict: true)) {
            throw new InvalidArgumentException(message: 'Invalid unit provided.');
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

        if ('km' === $unit) {
            return new self(value: $this->value * 1.609344, unit: $unit);
        }

        if ('mi' === $unit) {
            return new self(value: $this->value * 0.621371192, unit: $unit);
        }

        throw new InvalidArgumentException(message: 'Invalid unit provided.');
    }
}
