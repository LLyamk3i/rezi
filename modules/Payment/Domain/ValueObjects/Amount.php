<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\ValueObjects;

use Modules\Shared\Domain\Exceptions\InvalidValueObjectException;

final readonly class Amount
{
    /**
     * @throws InvalidValueObjectException
     */
    public function __construct(
        public int $value,
    ) {
        if ($value < 0) {
            throw new InvalidValueObjectException(value: $value, object: self::class);
        }
    }
}
