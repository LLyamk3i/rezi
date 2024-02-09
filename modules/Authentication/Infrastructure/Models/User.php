<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Modules\Shared\Infrastructure\Models\Media;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $guarded = ['id', 'updated_at', 'created_at'];

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

    /**
     * @return MorphOne<Media>
     */
    public function avatar(): MorphOne
    {
        return $this->morphOne(related: Media::class, name: 'fileable')
            ->where(column: 'type', operator: '=', value: EnumsMedia::Avatar);
    }

    /**
     * @return Attribute<string,null>
     */
    public function name(): Attribute
    {
        return Attribute::make(
            get: static fn (mixed $_, array $attributes): string => sprintf(
                '%s %s',
                $attributes['forename'],
                $attributes['surname']
            ),
        );
    }

    public function phoneNumber(): Attribute
    {
        return Attribute::make(get: static fn (mixed $_, array $attributes): string => $attributes['phone']);
    }

    public static function factory(): UserFactory
    {
        return new UserFactory();
    }
}
