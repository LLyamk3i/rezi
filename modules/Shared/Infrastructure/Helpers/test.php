<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Helpers;

use Illuminate\Support\Facades\Artisan;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Residence\Domain\Factories\ResidenceFactory;
use Modules\Residence\Domain\Hydrators\ResidenceHydrator;
use Modules\Residence\Infrastructure\Factories\ColumnsFactory;
use Modules\Shared\Infrastructure\Repositories\QueryRepository;
use Modules\Residence\Infrastructure\Eloquent\Repositories\EloquentResidenceRepository;

/**
 * @throws \RuntimeException
 */
function migrate_authentication(): void
{
    Artisan::call(
        command: 'migrate',
        parameters: ['--path' => 'modules/Authentication/Infrastructure/Database/Migrations']
    );
}

function residence_repository(): EloquentResidenceRepository
{
    $factory = new ResidenceFactory();

    return new EloquentResidenceRepository(
        factory: $factory,
        parent: new QueryRepository(),
        columns: new ColumnsFactory(),
        hydrator: new ResidenceHydrator(factory: $factory),
    );
}

/**
 * @return array{}
 */
function residence_factory(float $latitude, float $longitude): array
{
    return Residence::factory()
        ->location(value: new Location(...[$latitude, $longitude]))
        ->make()
        ->getAttributes();
}

function api_dd(...$vars): void
{
    var_dump(value: $vars);
    exit;
}
