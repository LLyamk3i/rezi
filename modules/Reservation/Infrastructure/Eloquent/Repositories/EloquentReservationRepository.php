<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Symfony\Component\Uid\Ulid as SymfonyUlid;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Reservation\Domain\Entities\Reservation as Entity;
use Modules\Reservation\Domain\Repositories\ReservationRepository;

final class EloquentReservationRepository implements ReservationRepository
{
    public function save(Entity $entity): void
    {
        $this->builder()->insert(values: [
            'id' => SymfonyUlid::generate(),
            'checkin_at' => $entity->stay->start,
            'checkout_at' => $entity->stay->end,
            'user_id' => $entity->user->value,
            'residence_id' => $entity->residence->value,
            'status' => $entity->status->value,
            'cost' => $entity->cost->value,
        ]);
    }

    public function exists(Duration $stay, Ulid $residence): bool
    {
        $query = $this->builder()
            ->where('residence_id', $residence->value)
            ->where(static function (Builder $query) use ($stay): void {
                $query->whereBetween('checkin_at', [$stay->start, $stay->end])
                    ->orWhereBetween('checkout_at', [$stay->start, $stay->end])
                    ->orWhere(static function (Builder $query) use ($stay): void {
                        $query->where('checkin_at', '<=', $stay->start)
                            ->where('checkout_at', '>=', $stay->end);
                    });
            });

        return $query->exists();
    }

    private function builder(): Builder
    {
        return DB::table(table: 'reservations');
    }
}
