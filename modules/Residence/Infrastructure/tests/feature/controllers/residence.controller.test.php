<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Testing\Assert;
use Modules\Residence\Infrastructure\Models\Residence;

use function Pest\Laravel\getJson;
use function Modules\Shared\Infrastructure\Helpers\route as r;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can list all residences', closure: function (): void {
    Residence::factory()->invisible()->create();
    $residences = Residence::factory()->owner()->visible()->count(count: 5)->create();

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
    $page = ['per' => 3, 'current' => 2, 'last' => (int) ceil(num: $total / 3)];
    $residences = Residence::factory()->count(count: $total)->visible()->poster()->owner()->create();
    $ids = $residences->forPage(page: $page['current'], perPage: $page['per'])->pluck(value: 'id');

    $response = getJson(uri: r(
        path: 'api/residences',
        queries: ['page' => $page['current'], 'per_page' => $page['per']]
    ));

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => 'La récupération des résidences a été effectuée avec succès.',
        'residences' => ['total' => $total, 'page' => $page],
    ]);

    $response->assertJsonPath(path: 'residences.items', expect: static function (array $residences) use ($ids): bool {
        collect(value: $residences)->each(callback: static function (array $residence) use ($ids): void {
            Assert::assertTrue(condition: \is_string(value: Arr::get(array: $residence, key: 'poster.link')));
            Assert::assertTrue(condition: \is_string(value: Arr::get(array: $residence, key: 'poster.usage')));
            Assert::assertTrue(condition: \is_string(value: Arr::get(array: $residence, key: 'owner.id')));
            Assert::assertTrue(condition: \is_string(value: Arr::get(array: $residence, key: 'owner.name')));
            Assert::assertTrue(condition: $ids->contains(key: $residence['id']));
        });

        return true;
    });
});
