<?php

declare(strict_types=1);

namespace Modules\Residence\Application\UseCases\NearestResidence;

use Modules\Residence\Domain\ValueObjects\Radius;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Residence\Domain\UseCases\NearestResidence\NearestResidenceRequest;
use Modules\Residence\Domain\UseCases\NearestResidence\NearestResidenceContract;
use Modules\Residence\Domain\UseCases\NearestResidence\NearestResidenceResponse;
use Modules\Residence\Domain\UseCases\NearestResidence\NearestResidencePresenterContract;

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
