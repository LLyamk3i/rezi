<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Eloquent\Repositories;

use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Modules\Reservation\Domain\Entities\Reservation as Entity;
use Modules\Reservation\Domain\Repositories\ReservationRepository;

final class EloquentReservationRepository implements ReservationRepository
{
    public function save(Entity $entity): void
    {
        $this->builder()->insert(values: [
            'id' => Ulid::generate(),
            'checkin_at' => $entity->checkin,
            'checkout_at' => $entity->checkout,
            'user_id' => $entity->user->value,
            'residence_id' => $entity->residence->value,
            'status' => $entity->status->value,
            'cost' => $entity->cost->value,
        ]);
    }

    private function builder(): Builder
    {
        return DB::table(table: 'reservations');
    }
}
