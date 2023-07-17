<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObjects;

use Modules\Shared\Domain\Exceptions\InvalidValueObjectException;

final class Price
{
    public const CURRENCY = 'FCFA';

    public function __construct(
        public readonly float $value,
    ) {
        if ($value < 0) {
            throw new InvalidValueObjectException(value: $value, object: self::class);
        }
    }
}
