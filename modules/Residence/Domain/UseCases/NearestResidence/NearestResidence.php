<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\NearestResidence;

use Modules\Residence\Domain\ValueObjects\Radius;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Residence\Domain\Contracts\NearestResidencePresenterContract;

class NearestResidence implements NearestResidenceContract
{
    public function __construct(
        private readonly ResidenceRepository $repository,
    ) {
    }

    public function execute(NearestResidenceRequest $request, NearestResidencePresenterContract $presenter): void
    {
        $response = new NearestResidenceResponse();

        $residences = $this->repository->nearest(
            location: new Location(latitude: $request->latitude, longitude: $request->longitude),
            radius: new Radius(value: $request->radius),
        );
        $response->setFailed(value: $residences === []);
        $response->setResidences(value: $residences);

        $presenter->present(response: $response);
    }
}
