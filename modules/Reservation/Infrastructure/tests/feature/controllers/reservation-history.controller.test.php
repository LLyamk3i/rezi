<?php

declare(strict_types=1);

use Filament\Support\Assets\Asset;
use Illuminate\Support\Arr;
use Illuminate\Testing\Assert;
use Modules\Reservation\Domain\Enums\Status;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Shared\Domain\ValueObjects\Duration;

use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Infrastructure\Models\Residence;

use Modules\Reservation\Domain\Services\CalculateReservationCostService;
use Modules\Reservation\Infrastructure\Models\Reservation;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;
use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\never;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test(description: 'user can list all is reservation history', closure: function (): void {
    /** @var Illuminate\Contracts\Auth\Authenticatable $user */
    Reservation::factory()->create();
    $user = User::factory()->create();
    $reservations = Reservation::factory()->client(model: $user)->count(count: 4)->create();

    $response = actingAs(user: $user)->getJson(uri: "/api/reservations/history/{$user->id}");

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => 'Voici votre historique de réservations.',
    ]);

    $response->assertJsonPath(path: 'reservations', expect: function (array $data) use ($reservations): bool {
        Assert::assertSameSize(expected: $reservations, actual: $data);
        Assert::assertSame(
            expected: $reservations->pluck(value: 'id')->toArray(),
            actual: Arr::pluck(array: $data, value: 'id')
        );
        return true;
    });
});
