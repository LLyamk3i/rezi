<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Repositories;

use Illuminate\Contracts\Database\Query\Builder;
use Modules\Shared\Application\Repositories\Repository;

final class QueryRepository implements Repository
{
    /**
     * @param array<int,\Illuminate\Contracts\Database\Query\Expression|string> $columns
     *
     * @return array<string,string|int|float>|null
     */
    public function find(Builder $query, array $columns = ['*']): ?array
    {
        /** @var \Illuminate\Database\Query\Builder $query */
        return $query->limit(value: 1)->get(columns: $columns)->first();
    }
}
