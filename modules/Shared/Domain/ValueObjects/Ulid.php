<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObjects;

use Modules\Shared\Domain\Exceptions\InvalidValueObjectException;

final class Ulid implements \Stringable
{
    public function __construct(
        public readonly string $value,
    ) {
        if (false === preg_match(pattern: '#^[0123456789ABCDEFGHJKMNPQRSTVWXYZ]{26}$#', subject: $value)) {
            throw new InvalidValueObjectException(value: $value, object: self::class);
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
