<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Models;

use Modules\Auth\Domain\Enums\Roles;
use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\FilamentUser;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Auth\Domain\Contracts\VerifyUserAccessManagerContract;
use Modules\Admin\Infrastructure\DataTransfertObjects\AuthenticatedObject;
use Modules\Admin\Infrastructure\Eloquent\QueryBuilders\AdminQueryBuilder;

final class Admin extends Authenticatable implements FilamentUser, HasName
{
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

    public function canAccessFilament(): bool
    {
        $key = AuthenticatedObject::make()->key(id: $this->id, suffix: 'role');
        $role = session()->get($key);

        if (\in_array(needle: $role, haystack: [Roles::Provider, Roles::Admin], strict: true)) {
            return true;
        }

        /** @var \Modules\Auth\Infrastructure\Managers\VerifyUserAccessManager $verify */
        $verify = app(abstract: VerifyUserAccessManagerContract::class);

        if ($verify->provider(user: new Ulid(value: $this->id))) {
            session()->put($key, Roles::Provider);

            return true;
        }

        if ($verify->admin(user: new Ulid(value: $this->id))) {
            session()->put($key, Roles::Admin);

            return true;
        }

        return false;
    }

    public function getFilamentName(): string
    {
        return "{$this->forename} {$this->surname}";
    }
}
