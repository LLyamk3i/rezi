<?php

use Illuminate\Support\Facades\DB;
use Modules\Residence\Infrastructure\Models\Favorite;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Infrastructure\Models\Residence;
use Symfony\Component\Uid\Ulid;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'returns a list of favorite residences', closure: function () {
    $client = User::factory()->create();
    $residences = Residence::factory()->poster()->count(count: 10)->create();

    $favorites = $residences->random(number: 5);
    $seeds = $favorites->map(callback: fn (Residence $residence): array => [
        'id' => Ulid::generate(),
        'user_id' => $client->id,
        'residence_id' => $residence->id
    ]);

    DB::table(table: 'favorites')->insert(values: $seeds->toArray());

    $response = actingAs(user: $client)->getJson(uri: "/api/residences/favorites");
    $response->assertOk();
    $response->assertJsonCount(count: $favorites->count(), key: 'residences');
    $response->assertJson(value: [
        'success' => true,
        'message' => 'Voici la liste de vos éléments favoris.',
    ]);
});

it(description: 'stores a new favorite residence', closure: function () {
    $client = User::factory()->create();
    $residence = Residence::factory()->create();

    $response = actingAs(user: $client)->postJson(uri: "/api/residences/favorites", data: ['residence_id' => $residence->id]);

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => "La residence a été ajouté à votre liste de favoris avec succès."
    ]);

    assertDatabaseHas(table: 'favorites', data: [
        'user_id' => $client->id,
        'residence_id' => $residence->id,
    ]);
});

it(description: 'removes a favorite residence', closure: function () {
    $client = User::factory()->create();
    $residence = Residence::factory()->create();
    $id = Ulid::generate();

    Favorite::query()->create(attributes: [
        'id' => $id,
        'user_id' => $client,
        'residence_id' => $residence
    ]);

    $response = actingAs(user: $client)->deleteJson(uri: "/api/residences/favorites/{$residence->id}");
    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => "a été retiré de votre liste de favoris avec succès."
    ]);

    assertDatabaseMissing(table: 'favorites', data: [
        'id' => $id,
        'user_id' => $client->id,
        'residence_id' => $residence->id,
    ]);
});
