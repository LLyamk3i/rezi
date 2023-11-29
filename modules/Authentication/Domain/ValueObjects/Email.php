<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\ValueObjects;

use Modules\Shared\Domain\Exceptions\InvalidValueObjectException;

final class Email implements \Stringable
{
    /**
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function __construct(
        public string $value,
    ) {
        if (filter_var($value, \FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidValueObjectException(value: $value, object: self::class);
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
