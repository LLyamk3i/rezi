<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Symfony\Component\Uid\Ulid;
use Modules\Reservation\Domain\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Reservation\Infrastructure\Models\Reservation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Reservation\Infrastructure\Models\Reservation>
 *
 * @phpstan-type ReservationFactoryResponse array{id:string,checkin_at:string,checkout_at:string,user_id:null,residence_id:null,status:mixed,cost:int<10000,500000>,created_at:string,updated_at:string}
 */
final class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    /**
     * @phpstan-return ReservationFactoryResponse
     */
    public function definition(): array
    {
        return [
            'id' => Ulid::generate(),
            'checkin_at' => (string) Carbon::now(),
            'checkout_at' => (string) Carbon::now()->addDay(),
            'user_id' => User::factory(),
            'residence_id' => Residence::factory(),
            'status' => Arr::random(array: Status::values()),
            'cost' => random_int(min: 10000, max: 500_000),
            'created_at' => (string) Carbon::now(),
            'updated_at' => (string) Carbon::now(),
        ];
    }

    public function client(User $model): self
    {
        return $this->state(state: ['user_id' => $model]);
    }

    public function residence(Residence $model): self
    {
        return $this->state(state: ['residence_id' => $model]);
    }
}
