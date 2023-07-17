<?php

declare(strict_types=1);

use Modules\Auth\Infrastructure\Models\User;

use Symfony\Component\Uid\Ulid;

use function Pest\Laravel\actingAs;
use Modules\Residence\Infrastructure\Models\Residence;
use function Modules\Shared\Infrastructure\Helpers\route;
use Modules\Reservation\Infrastructure\Models\Reservation;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can verify availability of residence', closure: function (): void {

    /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
    $user = User::factory()->create();
    $residence = Residence::factory()->create();

    $data = [
        'checkin_date' => now()->addDays(value: 5)->toDateTimeString(),
        'checkout_date' => now()->addDays(value: 10)->toDateTimeString(),
        'residence_id' => $residence->id,
    ];

    Reservation::factory()->create(attributes: [
        'checkin_at' => $data['checkin_date'],
        'checkout_at' => $data['checkout_date'],
        'residence_id' => $data['residence_id']
    ]);

    $response = actingAs(user: $user)->getJson(uri: route(path: '/api/reservations/availability', queries: $data));

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => 'La réservation exist.',
    ]);
});
