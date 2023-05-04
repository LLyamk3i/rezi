<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Residence\Domain\ValueObjects\Radius;
use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\Entities\Residence as Entity;
use Modules\Residence\Infrastructure\Models\Residence as Model;
use Modules\Residence\Infrastructure\Factories\EloquentResidenceRepositoryFactory;
use Modules\Residence\Application\Services\Location\RandomPositionGeneratorService;
use Modules\Residence\Infrastructure\Eloquent\Repositories\EloquentResidenceRepository;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

function repository(): EloquentResidenceRepository
{
    return (new EloquentResidenceRepositoryFactory())->make();
}

it(description: 'should fetch all residences from the database', closure: function (): void {
    $location = new Location(latitude: 48.864716, longitude: 2.349014);
    Model::factory()->location(value: $location)->count(count: 10)->create();

    $result = repository()->all();

    expect(value: $result)->toBeArray();
    expect(value: $result[0])->toBeInstanceOf(class: Entity::class);
    expect(value: $result)->toHaveCount(count: 10);
});

it(description: 'should find a residence by Ulid', closure: function (): void {
    $location = new Location(latitude: 48.864716, longitude: 2.349014);

    $residence_id = new Ulid(value: (string) Str::ulid()->generate());

    Model::factory()->id(value: (string) $residence_id)->location(value: $location)->create();

    $result = repository()->find(id: $residence_id);

    expect(value: $result)->toBeInstanceOf(class: Entity::class);
    expect(value: $result->id)->toEqual(expected: $residence_id);
});

it(description: 'should find the nearest residences to a given location', closure: function (): void {
    $location = new Location(latitude: 45.5017, longitude: -73.5673);
    $radius = new Radius(value: 10);
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

    $result = repository()->nearest(location: $location, radius: $radius);

    expect(value: $result)->toBeArray();
    expect(value: $result)->toHaveCount(count: 10);
    expect(value: $result[0])->toBeInstanceOf(class: Entity::class);
    expect(value: $result[0]->distance)->toBeInstanceOf(class: Distance::class);
    expect(value: $result[0]->distance->value)->toBeLessThanOrEqual(expected: $radius->value);
});
