<?php

declare(strict_types=1);

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

use Modules\Authentication\Infrastructure\Models\User;
use Modules\Reservation\Domain\Enums\Status;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Reservation\Domain\Services\CalculateReservationCostService;
use Modules\Shared\Domain\ValueObjects\Duration;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test(description: 'an unauthenticated user cannot create a reservation', closure: function (): void {
    $response = postJson(uri: '/api/reservations', data: []);

    $response->assertUnauthorized();
});

it(description: 'can create reservation', closure: function (): void {
    // \Illuminate\Support\Facades\DB::table('reservations')->truncate();

    /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
    $user = User::factory()->create();
    $residence = Residence::factory()->create();
    $calculator = new CalculateReservationCostService();

    $data = [
        'checkin_date' => now()->addDays(value: 5)->toDateString(),
        'checkout_date' => now()->addDays(value: 10)->toDateString(),
        'residence_id' => $residence->id,
    ];

    $cost = $calculator->execute(price: new Price(value: $residence->rent), duration: new Duration(
        start: new \DateTime(datetime: $data['checkin_date']),
        end: new \DateTime(datetime: $data['checkout_date']),
    ));

    $response = actingAs(user: $user)->postJson(uri: '/api/reservations', data: $data);

    $response->assertCreated();
    $response->assertJson(value: [
        'success' => true,
        'message' => 'La réservation a été créée avec succès.',
    ]);
    assertDatabaseHas(table: 'reservations', data: [
        'checkin_at' => $data['checkin_date'],
        'checkout_at' => $data['checkout_date'],
        'cost' => $cost->value,
        'user_id' => $user->id,
        'residence_id' => $residence->id,
        'status' => Status::PENDING,
    ]);
});
