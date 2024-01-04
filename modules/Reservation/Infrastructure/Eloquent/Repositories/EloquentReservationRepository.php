<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Reservation\Domain\Entities\Reservation as Entity;
use Modules\Reservation\Domain\Repositories\ReservationRepository;
use Modules\Reservation\Domain\Contracts\ReservationVerificationQueryContract;

final class EloquentReservationRepository implements ReservationRepository
{
    public function save(Entity $entity): void
    {
        DB::table(table: 'reservations')->insert(values: [
            'id' => $entity->id->value,
            'checkin_at' => $entity->stay->start,
            'checkout_at' => $entity->stay->end,
            'user_id' => $entity->owner?->value,
            'residence_id' => $entity->residence?->value,
            'status' => $entity->status?->value,
            'cost' => $entity->cost?->value,
        ]);
    }

    public function exists(ReservationVerificationQueryContract $checker): bool
    {
        return $checker->run();
    }
}
