<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Infrastructure\Eloquent\QueryBuilders\ClientQueryBuilder;

final class Client extends Model
{
    use \Modules\Shared\Infrastructure\Concerns\Model\UserConcern;

    public static function query(): ClientQueryBuilder
    {
        return parent::query()->default();
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     */
    public function newEloquentBuilder($query): ClientQueryBuilder
    {
        return new ClientQueryBuilder(query: $query);
    }
}
