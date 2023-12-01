<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Filters;

use Illuminate\Database\Query\Builder;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Residence\Domain\Contracts\FilterContract;

final readonly class StayDurationFilter implements FilterContract
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
                ->whereColumn('reservations.residence_id', 'residences.id')
                ->where(static function (Builder $query) use ($stay): void {
                    $query->whereBetween('reservations.checkin_at', [$stay->start, $stay->end])
                        ->orWhereBetween('reservations.checkout_at', [$stay->start, $stay->end])
                        ->orWhere(static function (Builder $query) use ($stay): void {
                            $query->where('reservations.checkin_at', '<=', $stay->start)
                                ->where('reservations.checkout_at', '>=', $stay->end);
                        });
                });
        });
    }
}
