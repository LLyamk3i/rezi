<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\DataTransferObjects;

/**
 * @template T
 */
final readonly class PaginatedObject
{
    /**
     * @var object{per:int,last:int,current:int}
     */
    public object $page;

    /**
     * @param array<int,T> $items
     */
    public function __construct(public array $items, public int $total, int $per_page, int $last_page, int $current_page)
    {
        $this->page = new class($per_page, $last_page, $current_page)
        {
            public function __construct(
                public int $per,
                public int $last,
                public int $current,
            ) {
                //
            }
        };
    }
}
