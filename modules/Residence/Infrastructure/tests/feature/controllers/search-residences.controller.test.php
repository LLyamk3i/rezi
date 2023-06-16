<?php

declare(strict_types=1);

use function Pest\Laravel\getJson;
use Illuminate\Support\Facades\DB;

use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Residence\Infrastructure\Models\Residence;
use function Modules\Shared\Infrastructure\Helpers\route;
use Modules\Reservation\Infrastructure\Models\Reservation;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it(description: 'can search residences by address', closure: function (): void {

    $data = [
        ['name' => 'residence xvrdbgjnnjd'],
        ['description' => 'welcome to residence xvrdbgjnnjddd'],
        ['address' => '456 Ghana Avenue, Kumasi, xvrdbgjnnjddsfdfbd'],
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
        'residence_id' => $seeds[0]->id,
    ]);

    $response = getJson(uri: route(path: 'api/residences/search', queries: [
        'checkin_date' => $stay->start->format(format: 'Y-m-d H:i'),
        'checkout_date' => $stay->start->format(format: 'Y-m-d H:i'),
        'location' => 'xvrdbgjnnjd xvrdbgjnnjddd xvrdbgjnnjddsfdfbd',
    ]));

    $response->assertOk();

    $response->assertJson(value: [
        'success' => true,
        'message' => 'Search completed successfully.',
        'total' => 2,
    ]);

    $response->assertJsonPath(path: 'data.0.description', expect: $data[1]['description']);
    $response->assertJsonPath(path: 'data.1.address', expect: $data[2]['address']);
});
