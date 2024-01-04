<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Filters;

use Illuminate\Database\Query\Builder;
use Modules\Residence\Domain\Contracts\FilterContract;

final readonly class TypesFilter implements FilterContract
{
    /**
     * @param array<int,string> $payload
     */
    public function __construct(
        private Builder $query,
        private array $payload,
    ) {
        //
    }

    public function filter(): void
    {
        $this->query->whereIn(column: 'residences.type_id', values: $this->payload);
    }
}
