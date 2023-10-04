<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Eloquent\Repositories\Methods;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Reservation\Domain\Contracts\ReservationVerificationQueryContract;

final class ReservationAvailabilityVerificationQuery implements ReservationVerificationQueryContract
{
    public function __construct(
        private readonly Duration $stay,
        private readonly Ulid $residence,
    ) {
        //
    }

    public function run(): bool
    {
        $stay = $this->stay;

        return DB::table(table: 'reservations')
            ->where('residence_id', $this->residence->value)
            ->where(static function (Builder $query) use ($stay): void {
                $query->whereBetween('checkin_at', [$stay->start, $stay->end])
                    ->orWhereBetween('checkout_at', [$stay->start, $stay->end])
                    ->orWhere(static function (Builder $query) use ($stay): void {
                        $query->where('checkin_at', '<=', $stay->start)
                            ->where('checkout_at', '>=', $stay->end);
                    });
            })
            ->exists();
    }
}
