<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Models;

use Filament\Panel;
use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Admin\Infrastructure\Eloquent\QueryBuilders\AdminQueryBuilder;
use Modules\Authentication\Domain\Contracts\VerifyUserAccessManagerContract;

use function Modules\Shared\Infrastructure\Helpers\make_ulid_value;

final class Admin extends Authenticatable implements FilamentUser, HasName
{
    use \Modules\Admin\Infrastructure\Concerns\Model\UserConcern;
    use \Modules\Shared\Infrastructure\Concerns\Model\UserConcern;

    public static function query(): AdminQueryBuilder
    {
        return parent::query()->default();
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     */
    public function newEloquentBuilder($query): AdminQueryBuilder
    {
        return new AdminQueryBuilder(query: $query);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function canAccessPanel(Panel $panel): bool
    {
        /** @var VerifyUserAccessManagerContract $verify */
        $verify = app(abstract: VerifyUserAccessManagerContract::class);

        return $verify->admin(user: make_ulid_value(value: $this->id));
    }
}
