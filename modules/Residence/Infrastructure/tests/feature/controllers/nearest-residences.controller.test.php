<?php

declare(strict_types=1);

use Illuminate\Support\Str;

use PHPUnit\Framework\Assert;

use function Pest\Laravel\getJson;
use Illuminate\Support\Facades\DB;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Application\Services\Location\RandomPositionGeneratorService;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

function row(float $latitude, float $longitude): array
{
    return [
        'id' => (string) Str::ulid()->generate(),
        'name' => fake()->streetAddress(),
        'location' => DB::raw("ST_PointFromText('POINT({$longitude} {$latitude})')"),
        'rent' => fake()->randomFloat(nbMaxDecimals: 2, max: 1_000_000),
        'address' => fake()->address(),
        'created_at' => now(),
        'updated_at' => now(),
    ];
}

test(description: 'can not find nearest residence', closure: function (): void {
    $location = new Location(latitude: 48.864716, longitude: 2.349014); // Center longitude (Paris, France)
    $radius = new Radius(value: 25);

    $response = getJson(uri: 'api/residences/nearest?' . http_build_query(data: [
        ...(array) $location,
        'radius' => $radius->value,
    ]));

    $response->assertBadRequest();

    $response->assertJson(value: [
        'success' => false,
        'message' => "Aucune résidence proche n'a été trouvée pour l'adresse demandée.",
    ]);

    $response->assertJsonPath(path: 'data', expect: function (array $residences): bool {
        Assert::assertCount(expectedCount: 0, haystack: $residences);

        return true;
    });
});

test(description: 'can find nearest residence', closure: function (): void {
    $location = new Location(latitude: 48.864716, longitude: 2.349014); // Center longitude (Paris, France)
    $radius = new Radius(value: 25);
    $generator = new RandomPositionGeneratorService(location: $location, radius: $radius);

    $rows = [];
    // Insert 10 positions within the radius
    for ($i = 1; $i <= 10; $i++) {
        $coordinates = $generator->execute();
        $rows[] = row(latitude: $coordinates['latitude'], longitude: $coordinates['longitude']);
    }
    // Insert 8 positions outside the radius
    for ($i = 1; $i <= 8; $i++) {
        $coordinates = $generator->execute();
        $rows[] = row(latitude: $coordinates['latitude'] * 2, longitude: $coordinates['longitude'] * 2);
    }

    DB::table(table: 'residences')->insert(values: $rows);

    $response = getJson(uri: 'api/residences/nearest?' . http_build_query(data: [
        ...(array) $location,
        'radius' => $radius->value,
    ]));

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => "Les résidences proches pour l'adresse demandée ont été trouvées.",
    ]);

    $response->assertJsonPath(path: 'data', expect: function (array $residences): bool {
        Assert::assertCount(expectedCount: 10, haystack: $residences);

        return true;
    });
});
