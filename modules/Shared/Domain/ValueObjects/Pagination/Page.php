<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObjects\Pagination;

final readonly class Page
{
    public function __construct(
        public int $current = 1,
        public int $per = 20,
    ) {
        //
    }
}
