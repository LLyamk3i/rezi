<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Repositories;

use Illuminate\Contracts\Database\Query\Builder;

interface Repository
{
    /**
     * @param array<int,\Illuminate\Contracts\Database\Query\Expression|string> $columns
     *
     * @return array<string,string|int|float>|null
     */
    public function find(Builder $query, array $columns = ['*']): ?array;
}
