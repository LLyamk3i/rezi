<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Eloquent\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<\Modules\Authentication\Infrastructure\Models\User>
 */
final class UserQueryBuilder extends Builder
{
    public function clients(): static
    {
        return $this;
    }
}
