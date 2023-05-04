<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObjects;

class Price
{
    public function __construct(
        public readonly float $value,
    ) {
        if ($value < 0) {
            throw new \InvalidArgumentException(message: "Invalid price value: {$value}");
        }
    }
}
