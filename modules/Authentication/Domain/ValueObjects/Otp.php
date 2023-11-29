<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\ValueObjects;

use Modules\Shared\Domain\Exceptions\InvalidValueObjectException;

final readonly class Otp implements \Stringable
{
    /**
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function __construct(
        public string $value,
    ) {
        if (! (bool) preg_match(pattern: '#^\d{3}-\d{3}$#', subject: $value)) {
            throw new InvalidValueObjectException(value: $value, object: self::class);
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
