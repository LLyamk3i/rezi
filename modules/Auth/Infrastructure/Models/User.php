<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Auth\Infrastructure\Database\Factories\UserFactory;
use Modules\Auth\Infrastructure\Eloquent\QueryBuilders\UserQueryBuilder;

final class User extends Authenticatable
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \Illuminate\Notifications\Notifiable;
    use \Laravel\Sanctum\HasApiTokens;
    use \Modules\Shared\Infrastructure\Concerns\Model\UserConcern;

    public static function query(): UserQueryBuilder
    {
        return parent::query();
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     */
    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder(query: $query);
    }

    public static function factory(): UserFactory
    {
        return new UserFactory();
    }
}
