<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Filters;

use Illuminate\Database\Query\Builder;
use Modules\Residence\Domain\Contracts\FilterContract;

final readonly class LatestFilter implements FilterContract
{
    public function __construct(
        private Builder $query,
    ) {
        //
    }

    public function filter(): void
    {
        $this->query->latest(column: 'residences.created_at');
    }
}
