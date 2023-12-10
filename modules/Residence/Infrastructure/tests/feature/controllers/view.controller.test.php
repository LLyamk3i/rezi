<?php

use Illuminate\Support\Arr;
use Modules\Residence\Infrastructure\Models\View;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Residence\Infrastructure\Models\Residence;
use Symfony\Component\Uid\Ulid;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'stores a new view residence', closure: function () {
    $residence = Residence::factory()->create();
    $device = ['name' => 'Linux', 'token' => Ulid::generate(),];
    $contacted = Arr::join(array: $device, glue: '/');

    $response = postJson(uri: "/api/residences/views", data: [
        'residence_id' => $residence->id,
        'device_name' => $device['name'],
        'device_token' => $device['token'],
    ]);

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => "La résidence a été marquée comme vue par {$contacted} avec succès."
    ]);

    assertDatabaseHas(table: 'views', data: [
        'device' => $contacted,
        'residence_id' => $residence->id,
    ]);
});

it(description: 'cannot mark a visited residence as viewed', closure: function () {
    $device = ['name' => 'Linux', 'token' => Ulid::generate(),];
    $contacted = Arr::join(array: $device, glue: '/');
    $residence = Residence::factory()->create();

    View::query()->create(attributes: [
        'id' => Ulid::generate(),
        'device' => $contacted,
        'residence_id' => $residence->id,
    ]);

    $response = postJson(uri: "/api/residences/views", data: [
        'residence_id' => $residence->id,
        'device_name' => $device['name'],
        'device_token' => $device['token'],
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(errors: [
        'residence_id' => "La résidence a été déjà marquée comme vue par {$contacted}."
    ]);
});
