<?php

declare(strict_types=1);

use Illuminate\Testing\Assert;
use Illuminate\Support\Facades\DB;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Reservation\Infrastructure\Models\Reservation;

use function Pest\Laravel\getJson;
use function Modules\Shared\Infrastructure\Helpers\route;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can search residences by address', closure: function (): void {
    $keyword = 'fadiga';
    $data = [
        ['name' => "residence {$keyword}"],
        ['description' => "welcome to residence {$keyword}"],
        ['address' => "456 Ghana Avenue, Kumasi, rue {$keyword}"],
    ];

    $seeds = Residence::factory()->template(data: $data)->count(count: 8)->make();

    DB::table(table: 'residences')->insert(values: $seeds->toArray());

    $date = now()->tomorrow();
    $stay = new Duration(
        start: new \DateTime(datetime: $date->format(format: 'Y-m-d H:i')),
        end: new \DateTime(datetime: $date->addDays(value: 8)->format(format: 'Y-m-d H:i'))
    );

    Reservation::factory()->create(attributes: [
        'checkin_at' => $stay->start,
        'checkout_at' => $stay->end,
        'residence_id' => $seeds->first()->id,
    ]);

    $response = getJson(uri: route(path: 'api/residences/search', queries: [
        'location' => $keyword,
        'checkin_date' => $stay->start->format(format: 'Y-m-d H:i'),
        'checkout_date' => $stay->start->format(format: 'Y-m-d H:i'),
    ]));

    $response->assertOk();
    $searchables = \array_slice(array: $data, offset: 1, length: 2);

    $response->assertJson(value: [
        'success' => true,
        'message' => \count(value: $searchables) . ' résidences ont été trouvées pour les paramètres de recherche donnés.',
        'residences' => ['total' => \count(value: $searchables)],
    ]);

    $response->assertJsonPath(path: 'residences.items', expect: function (array $residences) use ($searchables): bool {
        for ($i = 0; $i < \count(value: $searchables); $i++) {
            $searchable = $searchables[$i];
            foreach ($searchable as $key => $value) {
                Assert::assertTrue(condition: isset($residences[$i][$key]));
                Assert::assertTrue(condition: $residences[$i][$key] === $value);
            }
        }

        return true;
    });
});
