<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Filters;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Modules\Residence\Domain\Contracts\FilterContract;

final readonly class FeaturesFilter implements FilterContract
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
        $this->query->whereExists(callback: fn (Builder $query): \Illuminate\Database\Query\Builder => $query
            ->select(columns: DB::raw(value: 1))
            ->from(table: 'features')
            ->join(table: 'feature_residence', first: 'features.id', operator: '=', second: 'feature_residence.feature_id')
            ->whereColumn(first: 'residences.id', operator: '=', second: 'feature_residence.residence_id')
            ->whereIn(column: 'features.id', values: $this->payload));
    }
}
