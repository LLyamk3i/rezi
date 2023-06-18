<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Symfony\Component\Uid\Ulid;
use Modules\Reservation\Domain\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Reservation\Infrastructure\Models\Reservation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Reservation\Infrastructure\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    /**
     * @return array{id:string,checkin_at:Carbon,checkout_at:Carbon,user_id:null,residence_id:null,status:mixed,cost:int<10000,500000>,created_at:Carbon,updated_at:Carbon}
     */
    public function definition(): array
    {
        return [
            'id' => Ulid::generate(),
            'checkin_at' => Carbon::now(),
            'checkout_at' => Carbon::now()->addDay(),
            'user_id' => null,
            'residence_id' => null,
            'status' => Arr::random(array: Status::values()),
            'cost' => random_int(min: 10000, max: 500_000),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
