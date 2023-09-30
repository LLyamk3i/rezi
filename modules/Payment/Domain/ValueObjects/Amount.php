<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\ValueObjects;

use Modules\Shared\Domain\Exceptions\InvalidValueObjectException;

final class Amount
{
    public function __construct(
        public readonly int $value,
    ) {
        if ($value < 0) {
            throw new InvalidValueObjectException(value: $value, object: self::class);
        }
    }
}
