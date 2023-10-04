<?php

declare(strict_types=1);

namespace Modules\Payment\Infrastructure\Database\Factories;

use Symfony\Component\Uid\Ulid;
use Modules\Payment\Domain\Enums\Status;
use Modules\Payment\Infrastructure\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Reservation\Infrastructure\Models\Reservation;

/**
 * @extends Factory<Payment>
 */
final class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    /**
     * @return array<string,mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Ulid::generate(),
            'amount' => rand(min: 10_000, max: 100_000_000),
            'status' => Status::Pending->value,
            'payed_at' => null,
            'user_id' => $client = User::factory()->create(),
            'reservation_id' => Reservation::factory()->client(model: $client),
        ];
    }

    public function client(User $model): self
    {
        return $this->state(state: [
            'user_id' => $model,
            'reservation_id' => Reservation::factory()->client(model: $model),
        ]);
    }

    public function status(Status $enum): self
    {
        return $this->state(state: ['status' => $enum->value]);
    }

    public function payed(): self
    {
        return $this->state(state: ['payed_at' => fake()->dateTimeThisMonth()]);
    }
}
