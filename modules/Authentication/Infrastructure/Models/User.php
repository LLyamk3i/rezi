<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Modules\Shared\Infrastructure\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Residence\Domain\Enums\Media as EnumsMedia;
use Modules\Authentication\Infrastructure\Database\Factories\UserFactory;
use Modules\Authentication\Infrastructure\Eloquent\QueryBuilders\UserQueryBuilder;

final class User extends Authenticatable implements MustVerifyEmail
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \Illuminate\Notifications\Notifiable;
    use \Laravel\Sanctum\HasApiTokens;
    use \Modules\Shared\Infrastructure\Concerns\Model\UserConcern;

    /**
     * @return MorphOne<Media>
     */
    public function avatar(): MorphOne
    {
        return $this->morphOne(related: Media::class, name: 'fileable')->where('type', EnumsMedia::Avatar);
    }

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
