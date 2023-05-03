<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObjects;

use Modules\Shared\Domain\Exceptions\InvalidULIDException;

class Ulid implements \Stringable
{
    public function __construct(
        public readonly string $value,
    ) {
        if (false === preg_match(pattern: '#^[0123456789ABCDEFGHJKMNPQRSTVWXYZ]{26}$#', subject: $value)) {
            throw new InvalidULIDException("Invalid ulid value: {$value}");
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
