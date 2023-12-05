<?php

use Modules\Residence\Infrastructure\Models\View;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Infrastructure\Models\Residence;
use Symfony\Component\Uid\Ulid;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'stores a new view residence', closure: function () {
    $client = User::factory()->create();
    $residence = Residence::factory()->create();

    $response = actingAs(user: $client)->postJson(uri: "/api/residences/views", data: ['residence_id' => $residence->id]);

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => "La résidence a été marquée comme vue par {$client->id} avec succès."
    ]);

    assertDatabaseHas(table: 'views', data: [
        'user_id' => $client->id,
        'residence_id' => $residence->id,
    ]);
});

it(description: 'cannot mark a visited residence as viewed', closure: function () {
    $client = User::factory()->create();
    $residence = Residence::factory()->create();

    View::query()->create(attributes: [
        'id' => Ulid::generate(),
        'user_id' => $client->id,
        'residence_id' => $residence->id,
    ]);

    $response = actingAs(user: $client)->postJson(uri: "/api/residences/views", data: ['residence_id' => $residence->id]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(errors: [
        'residence_id' => "La résidence a été déjà marquée comme vue par {$client->id}."
    ]);
});
