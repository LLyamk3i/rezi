<?php

use function Pest\Laravel\actingAs;
use Modules\Payment\Domain\Enums\Status;

use function Pest\Laravel\assertDatabaseHas;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Payment\Infrastructure\Models\Payment;
use Modules\Reservation\Infrastructure\Models\Reservation;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can generate payment id for transaction', closure: function () {

    $user = User::factory()->verified()->create();
    $reservation = Reservation::factory()->create();

    $response = actingAs(user: $user)->postJson(uri: '/api/payment', data: [
        'amount' => $amount = 100_000_000,
        'reservation_id' => $reservation->id,
    ]);

    $response->assertCreated();

    $payment = Payment::query()->where(['user_id' => $user->id, 'reservation_id' => $reservation->id])->first();

    $response->assertJson(value: [
        'success' => true,
        'id' => $payment->id,
        'amount' => $amount,
        'message' => trans(key: 'payment::messages.initialization.success')
    ]);

    assertDatabaseHas(table: 'payments', data: [
        'amount' => $amount,
        'status' => Status::Pending->value,
        'user_id' => $user->id,
        'reservation_id' => $reservation->id,
        'payed_at' => null,
    ]);
});
