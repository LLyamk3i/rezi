<?php

declare(strict_types=1);

use Modules\Payment\Domain\Enums\Status;
use Modules\Payment\Infrastructure\Models\Payment;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Reservation\Infrastructure\Models\Reservation;

use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertSame;
use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertNotNull;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'must reject payment attempt from non owner reservation', closure: function (): void {

    $owner = User::factory()->verified()->create();
    $buyer = User::factory()->verified()->create();
    $reservation = Reservation::factory()->client(model: $owner)->create();

    $response = actingAs(user: $buyer)->postJson(uri: '/api/payments', data: [
        'amount' => 100_000_000,
        'reservation_id' => $reservation->id,
    ]);

    $response->assertForbidden();

    $response->assertJson(value: [
        'message' => trans(key: 'payment::validation.unauthorized.client'),
    ]);
});

it(description: 'can generate payment id for transaction', closure: function (): void {

    $user = User::factory()->verified()->create();
    $reservation = Reservation::factory()->client(model: $user)->create();

    $response = actingAs(user: $user)->postJson(uri: '/api/payments', data: [
        'amount' => $amount = 100_000_000,
        'reservation_id' => $reservation->id,
    ]);

    $response->assertCreated();

    assertDatabaseHas(table: 'payments', data: [
        'amount' => $amount,
        'status' => Status::Pending->value,
        'user_id' => $user->id,
        'reservation_id' => $reservation->id,
        'payed_at' => null,
    ]);

    $payment = Payment::query()->where(column: ['user_id' => $user->id, 'reservation_id' => $reservation->id])->first();

    $response->assertJson(value: [
        'success' => true,
        'amount' => $amount,
        'payment_id' => $payment->id,
        'message' => trans(key: 'payment::messages.initialization.success'),
    ]);
});

it(description: 'can patch the payment record with new response from payment getaway', closure: function (Status $status): void {

    $user = User::factory()->verified()->create();
    $payment = Payment::factory()->client(model: $user)->create();

    $response = actingAs(user: $user)->patchJson(uri: '/api/payments/' . $payment->id, data: ['status' => $status->value]);

    $response->assertAccepted();

    $record = Payment::query()->where(column: ['id' => $payment->id, 'user_id' => $user->id])->first();

    if ($status === Status::Completed) {
        assertNotNull(actual: $record->payed_at);
    }

    assertSame(expected: $status->value, actual: $record->status->value);

    $response->assertJson(value: [
        'success' => true,
        'payment_id' => $payment->id,
        'status' => $status->value,
        'message' => trans(key: 'payment::messages.update.success'),
    ]);
})->with([Status::Completed, Status::Canceled, Status::Failed]);
