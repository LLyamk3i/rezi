<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObjects;

use Modules\Shared\Domain\Exceptions\InvalidValueObjectException;

final readonly class Ulid implements \Stringable
{
    public function __construct(
        public string $value,
    ) {
        if (preg_match(pattern: '#^[0123456789ABCDEFGHJKMNPQRSTVWXYZ]{26}$#', subject: $value) === false) {
            throw new InvalidValueObjectException(value: $value, object: self::class);
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
