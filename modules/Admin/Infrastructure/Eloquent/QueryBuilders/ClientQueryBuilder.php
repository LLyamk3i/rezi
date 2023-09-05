<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Eloquent\QueryBuilders;

use Modules\Auth\Domain\Enums\Roles;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<\Modules\Admin\Infrastructure\Models\Client>
 */
final class ClientQueryBuilder extends Builder
{
    public function default(): static
    {
        return $this->whereHas(relation: 'roles', callback: static fn (Builder $query) => $query->where('name', Roles::Client))
            ->whereDoesntHave(relation: 'roles', callback: static fn (Builder $query) => $query->where('name', Roles::Admin))
            ->whereDoesntHave(relation: 'roles', callback: static fn (Builder $query) => $query->where('name', Roles::Owner));
    }

    public function lol(): static
    {
        return $this;
    }
}
