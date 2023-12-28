<?php

declare(strict_types=1);

use Modules\Reservation\Domain\Enums\Status;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Shared\Domain\ValueObjects\Duration;

use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Infrastructure\Models\Residence;

use Modules\Reservation\Domain\Services\CalculateReservationCostService;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;
use function Pest\Laravel\assertDatabaseHas;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test(description: 'an unauthenticated user cannot make a reservation', closure: function (): void {
    $response = postJson(uri: '/api/reservations', data: []);

    $response->assertUnauthorized();
});

it(description: 'can make reservation', closure: function (): void {
    // \Illuminate\Support\Facades\DB::table('reservations')->truncate();

    /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
    $user = User::factory()->create();
    $residence = Residence::factory()->visible()->create();
    $calculator = new CalculateReservationCostService();

    $data = [
        'residence_id' => $residence->id,
        'checkin_date' => now()->addDays(value: 5)->toDateTimeString(),
        'checkout_date' => now()->addDays(value: 10)->toDateTimeString(),
    ];

    $cost = $calculator->execute(price: new Price(value: $residence->rent), duration: new Duration(
        end: new \DateTime(datetime: $data['checkout_date']),
        start: new \DateTime(datetime: $data['checkin_date']),
    ));

    $response = actingAs(user: $user)->postJson(uri: '/api/reservations', data: $data);

    $response->assertCreated();
    $response->assertJson(value: [
        'success' => true,
        'message' => 'La réservation a été effectuée avec succès.',
    ]);
    $response->assertJsonPath(path: 'reservation_id', expect: static fn (string $_): true => true);
    assertDatabaseHas(table: 'reservations', data: [
        'cost' => $cost->value,
        'user_id' => $user->id,
        'status' => Status::PENDING,
        'residence_id' => $residence->id,
        'checkin_at' => $data['checkin_date'],
        'checkout_at' => $data['checkout_date'],
    ]);
});
