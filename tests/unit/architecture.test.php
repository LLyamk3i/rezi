<?php

declare(strict_types=1);

namespace Tests\unit;

use Illuminate\Testing\Assert;
use Illuminate\Support\Facades\DB;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;

use function Pest\Laravel\getJson;
use function Modules\Shared\Infrastructure\Helpers\route;
use function Modules\Shared\Infrastructure\Helpers\listen_queries;

test(description: 'globals')
    ->expect(value: ['dd', 'dump', 'listen_queries'])
    ->not->toBeUsed();

uses(\Tests\TestCase::class);
test(description: 'trash', closure: function (): void {
    $radius = new Radius(value: 25);
    $location = new Location(latitude: 5.21314, longitude: -3.74095); // Center longitude (Paris, France)
    $count = 10;

    $residences = DB::table(table: 'residences')->get()->toArray();

    dump($residences);

    listen_queries();
    $response = getJson(uri: route(path: 'api/residences/nearest', queries: [...$location->__serialize(), 'radius' => $radius->value]));
    dump($response->json());
    $response->assertOk();
    $response->assertJsonCount(count: $count, key: 'residences.items');
    $response->assertJson(value: [
        'success' => true,
        'message' => "{$count} résidences ont été trouvées dans la localité demandée.",
    ]);

    $response->assertJsonPath(path: 'residences.items', expect: static function (array $items) use ($residences): bool {

        foreach ($items as $item) {
            Assert::assertIsString(actual: $item['id']);
            Assert::assertIsString(actual: $item['name']);
            Assert::assertIsString(actual: $item['address']);
            Assert::assertIsString(actual: $item['distance']);
            Assert::assertArrayHasKey(key: 'latitude', array: $item['location']);
            Assert::assertArrayHasKey(key: 'longitude', array: $item['location']);
            Assert::assertIsFloat(actual: $item['location']['latitude']);
            Assert::assertIsFloat(actual: $item['location']['longitude']);
            Assert::assertEquals(
                expected: [...collect(value: $residences)->pluck(value: 'id')->sortDesc()],
                actual: [...collect(value: $items)->pluck(value: 'id')->sortDesc()],
            );
        }

        return true;
    });
});
