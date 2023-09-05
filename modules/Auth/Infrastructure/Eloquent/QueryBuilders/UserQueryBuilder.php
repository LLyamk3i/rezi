<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Eloquent\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<\Modules\Auth\Infrastructure\Models\User>
 */
final class UserQueryBuilder extends Builder
{
    public function clients(): static
    {
        return $this;
    }
}
