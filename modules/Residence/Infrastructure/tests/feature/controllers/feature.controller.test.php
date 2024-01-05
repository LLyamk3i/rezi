<?php

declare(strict_types=1);

use Illuminate\Testing\Assert;
use Modules\Residence\Infrastructure\Models\Feature;

use function Pest\Laravel\getJson;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test(description: 'listing all residence features', closure: function (): void {

    $seed = Feature::factory()->icon()->count(count: 5)->create();

    $response = getJson(uri: '/api/residences/features');

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => 'La récupération des points forts résidentiels a été menée à bien.',
    ]);

    $response->assertJsonPath(path: 'features', expect: static function (array $features) use ($seed): bool {
        Assert::assertCount(expectedCount: $seed->count(), haystack: $features);

        return true;
    });
});
