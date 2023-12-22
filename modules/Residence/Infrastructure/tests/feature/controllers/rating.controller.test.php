<?php

declare(strict_types=1);

use Symfony\Component\Uid\Ulid;
use Modules\Residence\Infrastructure\Models\Rating;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Infrastructure\Models\Residence;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseCount;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can rate residence', closure: function (): void {
    $client = User::factory()->create();
    $residence = Residence::factory()->create();
    $comment = fake()->paragraph();
    $rate = 4;

    $response = actingAs(user: $client)->postJson(uri: '/api/residences/ratings', data: [
        'residence_id' => $residence->id,
        'rating' => $rate,
        'comment' => $comment,
    ]);

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => "La résidence a été notée par #{$client->id} avec succès.",
    ]);

    assertDatabaseHas(table: 'ratings', data: [
        'user_id' => $client->id,
        'residence_id' => $residence->id,
        'comment' => $comment,
        'value' => $rate,
    ]);
});

it(description: 'cannot rerate residence', closure: function (): void {
    $client = User::factory()->create();
    $residence = Residence::factory()->create();
    $rating = 5;

    Rating::query()->create(attributes: [
        'id' => Ulid::generate(),
        'user_id' => $client->id,
        'residence_id' => $residence->id,
        'value' => $rating,
    ]);

    $response = actingAs(user: $client)->postJson(uri: '/api/residences/ratings', data: [
        'residence_id' => $residence->id,
        'rating' => $rating,
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(errors: [
        'residence_id' => "La résidence a été déjà notée par #{$client->id}.",
    ]);

    assertDatabaseCount(table: 'ratings', count: 1);
});
