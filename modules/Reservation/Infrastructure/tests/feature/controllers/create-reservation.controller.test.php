<?php

declare(strict_types=1);

use App\Models\User;
use function Pest\Laravel\actingAs;

use function Pest\Laravel\assertDatabaseHas;
use Modules\Reservation\Domain\Enums\Status;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Reservation\Domain\Services\CalculateReservationCostService;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can create reservation', closure: function (): void {
    // \Illuminate\Support\Facades\DB::table('reservations')->truncate();

    $residence = Residence::factory()->create();
    /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
    $user = User::factory()->create();
    $calculator = new CalculateReservationCostService();

    $data = [
        'checkin_date' => now()->addDays(value: 5)->toDateString(),
        'checkout_date' => now()->addDays(value: 10)->toDateString(),
        'residence_id' => $residence->id,
    ];

    $cost = $calculator->execute(
        start: new \DateTime(datetime: $data['checkout_date']),
        end: new \DateTime(datetime: $data['checkin_date']),
        price: new Price(value: $residence->rent)
    );

    $response = actingAs(user: $user)->postJson(uri: '/api/reservations', data: $data);
    $response->assertCreated();
    $response->assertJson(value: [
        'success' => true,
        'message' => 'La réservation a été créée avec succès.',
    ]);
    assertDatabaseHas('reservations', [
        'checkin_at' => $data['checkin_date'],
        'checkout_at' => $data['checkout_date'],
        'cost' => $cost->value,
        'user_id' => $user->id,
        'residence_id' => $residence->id,
        'status' => Status::PENDING,
    ]);
});
