<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;
use Modules\Residence\Application\Services\Location\RandomPositionGeneratorService;

use function Pest\Laravel\getJson;
use function Modules\Shared\Infrastructure\Helpers\using_sqlite;
use function Modules\Shared\Infrastructure\Helpers\residence_factory;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can not find nearest residence', closure: function (): void {
    $location = new Location(latitude: 48.864716, longitude: 2.349014); // Center longitude (Paris, France)
    $radius = new Radius(value: 25);

    $response = getJson(uri: 'api/residences/nearest?' . http_build_query(data: [...(array) $location, 'radius' => $radius->value]));

    $response->assertNotFound();

    $response->assertJson(value: [
        'success' => false,
        'residences' => null,
        'message' => "Aucune résidence proche n'a été trouvée pour l'adresse demandée.",
    ]);
})->skip(conditionOrMessage: fn () => using_sqlite());

it(description: 'can find nearest residence', closure: function (): void {
    $location = new Location(latitude: 48.864716, longitude: 2.349014); // Center longitude (Paris, France)
    $radius = new Radius(value: 25);
    $generator = new RandomPositionGeneratorService(location: $location, radius: $radius);

    $count = 10;
    $residences = [];

    // Insert 10 positions within the radius
    for ($i = 1; $i <= $count; $i++) {
        $coordinates = $generator->execute();
        $residences[] = residence_factory(latitude: $coordinates['latitude'], longitude: $coordinates['longitude']);
    }

    // Insert 8 positions outside the radius
    for ($i = 1; $i <= 8; $i++) {
        $coordinates = $generator->execute();
        $residences[] = residence_factory(latitude: $coordinates['latitude'] * 2, longitude: $coordinates['longitude'] * 2);
    }

    DB::table(table: 'residences')->insert(values: $residences);

    $response = getJson(uri: 'api/residences/nearest?' . http_build_query(data: [...(array) $location, 'radius' => $radius->value]));

    $response->assertOk();
    $response->assertJsonCount(count: $count, key: 'residences.items');
    $response->assertJson(value: [
        'success' => true,
        'message' => "{$count} résidences ont été trouvées dans la localité demandée.",
    ]);
})->skip(conditionOrMessage: fn () => using_sqlite());
