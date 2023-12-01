<?php

use Modules\Residence\Infrastructure\Models\Type;

use function Pest\Laravel\getJson;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test(description: 'listing all residence types', closure: function () {

    $types = Type::factory()->count(count: 4)->create();

    $response = getJson(uri: '/api/residences/types');

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => 'La récupération des types résidences a été effectuée avec succès.',
        'types' => $types->only(keys: ['id', 'name'])->toArray(),
    ]);
});
