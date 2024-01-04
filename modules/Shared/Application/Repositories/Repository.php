<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Repositories;

use Illuminate\Contracts\Database\Query\Builder;
use Modules\Shared\Domain\Contracts\HydratorContract;
use Modules\Shared\Domain\ValueObjects\Pagination\Page;
use Modules\Shared\Domain\DataTransferObjects\PaginatedObject;

interface Repository
{
    /**
     * @param array<int,\Illuminate\Contracts\Database\Query\Expression|string> $columns
     *
     * @return array<string,string|int|float>|null
     */
    public function find(Builder $query, array $columns = ['*']): null | array;

    /**
     * @template H1
     * @template H2
     *
     * @param HydratorContract<H1,H2>                                           $hydrator
     * @param array<int,\Illuminate\Contracts\Database\Query\Expression|string> $columns
     *
     * @return PaginatedObject<H2>
     */
    public function paginate(Builder $query, Page $page, HydratorContract $hydrator, array $columns = ['*']): PaginatedObject;
}
