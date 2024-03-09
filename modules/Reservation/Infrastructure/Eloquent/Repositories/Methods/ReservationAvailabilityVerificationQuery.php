<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Eloquent\Repositories\Methods;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Reservation\Domain\Contracts\ReservationExistsQueryContract;

final readonly class ReservationAvailabilityVerificationQuery implements ReservationExistsQueryContract
{
    public function __construct(
        private Duration $stay,
        private Ulid $residence,
    ) {
        //
    }

    public function run(): bool
    {
        $stay = $this->stay;

        return DB::table(table: 'reservations')
            ->where(column: 'residence_id', operator: '=', value: $this->residence->value)
            ->where(static function (Builder $query) use ($stay): void {
                $query->whereBetween(column: 'checkin_at', values: [$stay->start, $stay->end])
                    ->orWhereBetween(column: 'checkout_at', values: [$stay->start, $stay->end])
                    ->orWhere(column: static function (Builder $query) use ($stay): void {
                        $query->where(column: 'checkin_at', operator: '<=', value: $stay->start)
                            ->where(column: 'checkout_at', operator: '>=', value: $stay->end);
                    });
            })
            ->exists();
    }
}
