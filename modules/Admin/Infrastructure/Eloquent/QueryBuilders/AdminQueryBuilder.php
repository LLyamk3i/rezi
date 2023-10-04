<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Eloquent\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Modules\Authentication\Domain\Enums\Roles;

/**
 * @extends Builder<\Modules\Admin\Infrastructure\Models\Admin>
 */
final class AdminQueryBuilder extends Builder
{
    public function default(): static
    {
        return $this->whereHas(relation: 'roles', callback: static fn (Builder $query): \Illuminate\Database\Eloquent\Builder => $query->where('name', Roles::Admin))
            ->whereDoesntHave(relation: 'roles', callback: static fn (Builder $query): \Illuminate\Database\Eloquent\Builder => $query->where('name', Roles::Owner));
    }
}
