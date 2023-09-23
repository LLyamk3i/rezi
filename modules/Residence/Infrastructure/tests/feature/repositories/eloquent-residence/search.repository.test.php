<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Reservation\Infrastructure\Models\Reservation;
use Modules\Residence\Domain\Entities\Residence as Entity;
use Modules\Residence\Infrastructure\Models\Residence as Model;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

$search = [
    'data' => [
        ['name' => 'residence xvrdbgjnnjd'],
        ['description' => 'welcome to residence xvrdbgjnnjddd'],
        ['address' => '456 Ghana Avenue, Kumasi, xvrdbgjnnjddsfdfbd'],
    ],
    'key' => 'xvrdbgjnnjd xvrdbgjnnjddd xvrdbgjnnjddsfdfbd',
];

it(description: 'could search residences in specified fields', closure: function () use ($search): void {
    $seeds = Model::factory()->template(data: $search['data'])->count(count: 8)->make();

    DB::table(table: 'residences')->insert(values: $seeds->toArray());

    $results = residence_repository()->search(key: $search['key']);

    expect(value: $results)->toBeArray();
    expect(value: $results)->toHaveCount(count: \count(value: $search['data']));
    expect(value: $results)->toContainOnlyInstancesOf(class: Entity::class);
    expect(value: $results[0]->name)->toBe(expected: $search['data'][0]['name']);
});

it(description: 'can only return residences not reserved', closure: function () use ($search): void {
    $seeds = Model::factory()->template(data: $search['data'])->count(count: 8)->make();

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

    $results = residence_repository()->search(key: $search['key'], stay: $stay);

    expect(value: $results)->toBeArray();
    expect(value: $results)->toHaveCount(count: \count(value: $search['data']) - 1);
    expect(value: $results)->toContainOnlyInstancesOf(class: Entity::class);
    expect(value: $results[0]->description)->toBe(expected: $search['data'][1]['description']);
});
