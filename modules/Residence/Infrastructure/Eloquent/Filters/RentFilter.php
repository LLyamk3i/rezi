<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Filters;

use Illuminate\Database\Query\Builder;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Residence\Domain\Contracts\FilterContract;

/**
 * @phpstan-import-type Search from \Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesRequest
 */
final readonly class RentFilter implements FilterContract
{
    /**
     * @phpstan-param Search['rent'] $payload
     */
    public function __construct(
        private Builder $query,
        private array $payload,
    ) {
        //
    }

    public function filter(): void
    {
        $this->query
            ->when(
                value: $this->payload['min'],
                callback: static fn (Builder $query, Price $value): \Illuminate\Database\Query\Builder => $query->where(column: 'rent', operator: '>=', value: $value->value)
            )
            ->when(
                value: $this->payload['max'] ?? null,
                callback: static fn (Builder $query, Price $value): \Illuminate\Database\Query\Builder => $query->where(column: 'rent', operator: '<=', value: $value->value)
            );
    }
}
