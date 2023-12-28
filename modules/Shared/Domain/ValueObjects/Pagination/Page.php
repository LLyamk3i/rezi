<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObjects\Pagination;

use Modules\Shared\Domain\Exceptions\InvalidValueObjectException;

final readonly class Page
{
    /**
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function __construct(
        public int $per,
        public int $current,
    ) {
        if ($per < 1) {
            throw new InvalidValueObjectException(value: $per, object: self::class);
        }

        if ($current < 1) {
            throw new InvalidValueObjectException(value: $per, object: self::class);
        }
    }
}
