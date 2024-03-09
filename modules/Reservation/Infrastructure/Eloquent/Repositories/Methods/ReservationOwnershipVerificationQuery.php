<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Eloquent\Repositories\Methods;

use Illuminate\Support\Facades\DB;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Reservation\Domain\Contracts\ReservationExistsQueryContract;

final readonly class ReservationOwnershipVerificationQuery implements ReservationExistsQueryContract
{
    public function __construct(
        private Ulid $owner,
        private Ulid $reservation,
    ) {
        //
    }

    public function run(): bool
    {
        return DB::table(table: 'reservations')
            ->where(column: 'user_id', operator: '=', value: $this->owner->value)
            ->where(column: 'id', operator: '=', value: $this->reservation->value)
            ->exists();
    }
}
