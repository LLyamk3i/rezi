<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Eloquent\Repositories\Methods;

use Illuminate\Support\Facades\DB;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Reservation\Domain\Contracts\ReservationVerificationQueryContract;

final readonly class ReservationOwnershipVerificationQuery implements ReservationVerificationQueryContract
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
            ->where(['user_id' => $this->owner->value, 'id' => $this->reservation->value])
            ->exists();
    }
}
