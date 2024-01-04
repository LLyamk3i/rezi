<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Filters;

use Illuminate\Database\Query\Builder;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Residence\Domain\Contracts\FilterContract;

final readonly class StayFilter implements FilterContract
{
    public function __construct(
        private Builder $query,
        private Duration $payload,
    ) {
        //
    }

    public function filter(): void
    {
        $stay = $this->payload;

        $this->query->whereNotExists(static function (Builder $query) use ($stay): void {
            $query->select(columns: ['id'])
                ->from(table: 'reservations')
                ->whereColumn(first: 'reservations.residence_id', operator: '=', second: 'residences.id')
                ->where(column: static function (Builder $query) use ($stay): void {
                    $query->whereBetween(column: 'reservations.checkin_at', values: [$stay->start, $stay->end])
                        ->orWhereBetween(column: 'reservations.checkout_at', values: [$stay->start, $stay->end])
                        ->orWhere(column: static function (Builder $query) use ($stay): void {
                            $query->where(column: 'reservations.checkin_at', operator: '<=', value: $stay->start)
                                ->where(column: 'reservations.checkout_at', operator: '>=', value: $stay->end);
                        });
                });
        });
    }
}
