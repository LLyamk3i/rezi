<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObjects;

use Modules\Shared\Domain\Exceptions\InvalidValueObjectException;

final readonly class Price
{
    public const CURRENCY = 'FCFA';

    public function __construct(
        public float $value,
    ) {
        if ($value < 0) {
            throw new InvalidValueObjectException(value: $value, object: self::class);
        }
    }
}
