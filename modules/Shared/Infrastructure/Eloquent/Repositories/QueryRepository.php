<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Eloquent\Repositories;

use Illuminate\Contracts\Database\Query\Builder;
use Modules\Shared\Domain\Contracts\HydratorContract;
use Modules\Shared\Application\Repositories\Repository;
use Modules\Shared\Domain\ValueObjects\Pagination\Page;
use Modules\Shared\Domain\DataTransferObjects\PaginatedObject;

final class QueryRepository implements Repository
{
    /**
     * @param array<int,\Illuminate\Contracts\Database\Query\Expression|string> $columns
     *
     * @return array<string,string|int|float>|null
     */
    public function find(Builder $query, array $columns = ['*']): null | array
    {
        /** @var \Illuminate\Database\Query\Builder $query */
        $result = $query->limit(value: 1)->get(columns: $columns)->first();

        if (\is_array($result)) {
            return $result;
        }

        return null;
    }

    /**
     * @template H1
     * @template H2
     *
     * @param HydratorContract<H1,H2>                                           $hydrator
     * @param array<int,\Illuminate\Contracts\Database\Query\Expression|string> $columns
     *
     * @return PaginatedObject<H2>
     */
    public function paginate(Builder $query, Page $page, HydratorContract $hydrator, array $columns = ['*']): PaginatedObject
    {
        /** @var \Illuminate\Database\Query\Builder $query */
        $pagination = $query->paginate(
            columns: $columns,
            perPage: $page->per,
            page: $page->current,
        );

        return new PaginatedObject(
            total: $pagination->total(),
            per_page: $pagination->perPage(),
            last_page: $pagination->lastPage(),
            current_page: $pagination->currentPage(),
            items: $hydrator->hydrate(data: $pagination->items())
        );
    }
}
