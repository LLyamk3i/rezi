<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Eloquent\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Modules\Authentication\Domain\Enums\Roles;

/**
 * @extends Builder<\Modules\Admin\Infrastructure\Models\Provider>
 */
final class ProviderQueryBuilder extends Builder
{
    public function default(): static
    {
        return $this->whereHas(relation: 'roles', callback: static fn (Builder $query): Builder => $query
            ->where(column: 'name', operator: '=', value: Roles::Provider))
            ->whereDoesntHave(relation: 'roles', callback: static fn (Builder $query): Builder => $query
                ->where(column: 'name', operator: '=', value: Roles::Admin))
            ->whereDoesntHave(relation: 'roles', callback: static fn (Builder $query): Builder => $query
                ->where(column: 'name', operator: '=', value: Roles::Owner));
    }
}
