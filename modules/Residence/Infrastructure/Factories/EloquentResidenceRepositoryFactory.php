<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Factories;

use Modules\Residence\Domain\Factories\ResidenceFactory;

use Modules\Residence\Domain\Hydrators\ResidenceHydrator;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Residence\Infrastructure\Eloquent\Repositories\EloquentResidenceRepository;

final class EloquentResidenceRepositoryFactory
{
    public function make(): ResidenceRepository
    {
        $factory = new ResidenceFactory();

        return new EloquentResidenceRepository(
            factory: $factory,
            hydrator: new ResidenceHydrator(factory: $factory)
        );
    }
}
