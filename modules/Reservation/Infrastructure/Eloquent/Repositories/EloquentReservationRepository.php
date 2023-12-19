<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Duration;
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
            'user_id' => $entity->user->value,
            'residence_id' => $entity->residence->value,
            'status' => $entity->status->value,
            'cost' => $entity->cost->value,
        ]);
    }

    // public function exists(Duration $stay, Ulid $residence): bool
    // {
    //     $query = DB::table(table: 'reservations')
    //         ->where('residence_id', $residence->value)
    //         ->where(static function (Builder $query) use ($stay): void {
    //             $query->whereBetween('checkin_at', [$stay->start, $stay->end])
    //                 ->orWhereBetween('checkout_at', [$stay->start, $stay->end])
    //                 ->orWhere(static function (Builder $query) use ($stay): void {
    //                     $query->where('checkin_at', '<=', $stay->start)
    //                         ->where('checkout_at', '>=', $stay->end);
    //                 });
    //         });

    //     return $query->exists();
    // }

    public function exists(ReservationVerificationQueryContract $checker): bool
    {
        return $checker->run();
    }
}
