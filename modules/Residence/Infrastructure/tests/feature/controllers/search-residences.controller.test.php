<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Testing\Assert;
use Illuminate\Database\Eloquent\Collection;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Residence\Infrastructure\Models\Feature;
use Modules\Residence\Infrastructure\Models\Residence;

use Modules\Reservation\Infrastructure\Models\Reservation;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Modules\Shared\Infrastructure\Helpers\route;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test(description: 'search residences by keyword', closure: function (): void {
    $keyword = 'fadiga';
    $searchables = [
        ['name' => "residence {$keyword}"],
        ['description' => "welcome to residence {$keyword}"],
        ['address' => "456 Ghana Avenue, Kumasi, rue {$keyword}"],
    ];
    Residence::factory()->visible()->owner()->template(data: $searchables)->count(count: 5)->create();
    $response = getJson(uri: route(path: 'api/residences/search', queries: ['keyword' => $keyword]));

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => \count(value: $searchables) . ' résidences ont été trouvées pour les paramètres de recherche donnés.',
        'residences' => ['total' => \count(value: $searchables)],
    ]);
    $response->assertJsonPath(path: 'residences.items', expect: static function (array $residences) use ($searchables): bool {
        foreach ($searchables as $i => $searchable) {
            foreach ($searchable as $key => $value) {
                Assert::assertTrue(condition: isset($residences[$i][$key]));
                Assert::assertTrue(condition: $residences[$i][$key] === $value);
            }
        }

        return true;
    });
});

test(description: 'search residences by stay', closure: function (): void {
    $stay = new Duration(
        start: new DateTime(datetime: now()->toString()),
        end: new DateTime(datetime: now()->addDays(value: 8)->toString())
    );
    $residences = Residence::factory()->owner()->visible()->count(count: 5)->create();
    $searchables = $residences->slice(offset: 1);
    Reservation::factory()->create(attributes: [
        'checkin_at' => $stay->start,
        'checkout_at' => $stay->end,
        'residence_id' => $residences->first()->id,
    ]);
    $response = getJson(uri: route(path: 'api/residences/search', queries: [
        'checkin_date' => $stay->start->format(format: 'Y-m-d H:i:s'),
        'checkout_date' => $stay->start->format(format: 'Y-m-d H:i:s'),
    ]));

    $response->assertOk();
    $response->assertJson(value: [
        'success' => true,
        'message' => $searchables->count() . ' résidences ont été trouvées pour les paramètres de recherche donnés.',
        'residences' => ['total' => $searchables->count()],
    ]);
    $response->assertJsonPath(path: 'residences.items', expect: static function (array $residences) use ($searchables): bool {
        Assert::assertSame(
            expected: collect(value: $residences)->pluck(value: 'id')->sort()->values()->toArray(),
            actual: $searchables->pluck(value: 'id')->sort()->values()->toArray(),
        );

        return true;
    });
});

test(description: 'search residences by rent range', closure: function (): void {
    $rent = ['min' => 1000, 'max' => 150000];
    Residence::factory()->owner()->visible()->count(count: 2)->create();
    $searchables = Residence::factory()->owner()->visible()->state(state: ['rent' => random_int(...$rent)])->create();

    $response = getJson(uri: route(path: 'api/residences/search', queries: [
        'rent_min' => $rent['min'],
        'rent_max' => $rent['max'],
    ]));
    $response->assertOk();
    $response->assertJsonPath(path: 'residences.items', expect: static function (array $residences) use ($searchables): bool {
        Assert::assertGreaterThanOrEqual(actual: $searchables->count(), expected: \count(value: $residences));
        Assert::assertLessThan(expected: $searchables->count(), actual: \count(value: $residences));

        return true;
    });
});

test(description: 'search residences by features', closure: function (string | array $features): void {
    Residence::factory()->visible()->count(count: 2)->create();
    $searchable = Residence::factory()->owner()->visible()->create();
    $searchable->features()->sync(ids: Arr::wrap(value: $features));

    if (\is_string(value: $features)) {
        $response = getJson(uri: route(path: 'api/residences/search', queries: ['feature_ids' => $features]));
    } else {
        $response = postJson(uri: 'api/residences/search', data: ['feature_ids' => $features]);
    }

    $response->assertOk();
    $response->assertJsonPath(path: 'residences.items', expect: static function (array $residences) use ($searchable): bool {
        Assert::assertCount(expectedCount: 1, haystack: $residences);
        Assert::assertSame(expected: $residences[0]['id'], actual: $searchable->id);

        return true;
    });
})->with([
    'using one feature' => fn (): string => Feature::factory()->create(attributes: ['name' => 'Swimming Pool'])->id,
    'using many features' => fn (): array => Feature::factory()->count(count: 4)->create()->pluck(value: 'id')->toArray(),
]);

test(description: 'search residences by types', closure: function (Residence | Collection $searchables): void {
    Residence::factory()->visible()->count(count: 2)->create();

    if ($searchables instanceof Residence) {
        $response = getJson(uri: route(path: 'api/residences/search', queries: ['type_ids' => $searchables->type_id]));
        $response->assertOk();
        $response->assertJsonPath(path: 'residences.items', expect: static function (array $residences) use ($searchables): bool {
            Assert::assertCount(expectedCount: 1, haystack: $residences);
            Assert::assertSame(expected: $residences[0]['id'], actual: $searchables->id);

            return true;
        });
    } else {
        $response = postJson(uri: 'api/residences/search', data: ['type_ids' => $searchables->pluck(value: 'type_id')]);
        $response->assertOk();
        $response->assertJsonPath(path: 'residences.items', expect: static function (array $residences) use ($searchables): bool {
            Assert::assertCount(expectedCount: $searchables->count(), haystack: $residences);
            Assert::assertSame(
                expected: collect(value: $residences)->pluck(value: 'id')->sort()->values()->toArray(),
                actual: $searchables->pluck(value: 'id')->sort()->values()->toArray(),
            );

            return true;
        });
    }
})->with([
    'using one type' => fn (): Residence => Residence::factory()->owner()->visible()->create(),
    'using many types' => fn (): Collection => Residence::factory()->owner()->visible()->count(count: 4)->create(),
]);

test(description: 'search latest residences', closure: function (): void {
    $searchables = Residence::factory()->owner()->visible()->count(count: 2)->create();

    $response = getJson(uri: route(path: 'api/residences/search', queries: ['latest' => true]));
    $response->assertOk();
    $response->assertJsonPath(path: 'residences.items', expect: static function (array $residences) use ($searchables): bool {
        Assert::assertSame(
            expected: collect(value: $residences)->pluck(value: 'id')->toArray(),
            actual: $searchables->pluck(value: 'id')->toArray(),
        );

        return true;
    });
});
