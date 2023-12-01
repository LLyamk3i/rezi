<?php

use Illuminate\Support\Arr;
use Illuminate\Testing\Assert;
use function Pest\Laravel\getJson;
use Illuminate\Support\Facades\DB;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Residence\Infrastructure\Models\Residence;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can list all residences', closure: function (): void {
    DB::table(table: 'residences')->truncate();
    $residences = Residence::factory()->count(count: 5)->create();

    $response = getJson(uri: 'api/residences');
    $response->assertOk();

    $response->assertJson(value: [
        'success' => true,
        'message' => 'La récupération des résidences a été effectuée avec succès.',
    ]);

    $response->assertJsonCount(count: $residences->count(), key: 'residences.items');
});

it(description: 'can paginate residences', closure: function (): void {
    $total = 10;
    $page = ['max' => 3, 'current' => 2];

    DB::table(table: 'residences')->truncate();
    $residences = Residence::factory()->poster()->owners(count: 3)->count(count: $total)->create();

    $ids = $residences->forPage(page: $page['current'], perPage: $page['max'])->pluck(value: 'id');

    $response = getJson(uri: 'api/residences?' . http_build_query(data: ['page' => $page['current'], 'per_page' =>  $page['max']]));

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => 'La récupération des résidences a été effectuée avec succès.',
        'residences' => [
            'total' => $total,
            'page' => [
                'per' =>  $page['max'],
                'current' => $page['current'],
                'last' => (int) ceil(num: $total /  $page['max']),
            ]
        ]
    ]);
    $response->assertJsonPath(path: 'residences.items', expect: function (array $residences) use ($ids): bool {
        collect(value: $residences)->each(callback: function (array $residence) use ($ids): void {
            Assert::assertTrue(condition: is_string(value: Arr::get(array: $residence, key: 'poster.value')));
            Assert::assertTrue(condition: is_string(value: Arr::get(array: $residence, key: 'poster.usage')));
            Assert::assertTrue(condition: is_string(value: Arr::get(array: $residence, key: 'owner.id')));
            Assert::assertTrue(condition: is_string(value: Arr::get(array: $residence, key: 'owner.name')));
            Assert::assertTrue(condition: $ids->contains(key: $residence['id']));
        });
        return true;
    });
});
