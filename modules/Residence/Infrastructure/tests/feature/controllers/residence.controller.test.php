<?php

use Illuminate\Support\Facades\DB;
use Modules\Residence\Infrastructure\Models\Residence;

use function Pest\Laravel\getJson;

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
    $residences = Residence::factory()->count(count: $total)->create();
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
    $response->assertJsonPath(path: 'residences.items', expect: function (array $results) use ($ids, $page): bool {
        collect(value: $results)->each(callback: function (array $residence) use ($ids): void {
            $ids->contains(key: $residence['id']);
        });
        return true;
    });
});
