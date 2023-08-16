<?php

declare(strict_types=1);

namespace Modules\Residence\Application\UseCases\NearestResidences;

use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Residence\Domain\UseCases\NearestResidences\NearestResidencesRequest;
use Modules\Residence\Domain\UseCases\NearestResidences\NearestResidencesContract;
use Modules\Residence\Domain\UseCases\NearestResidences\NearestResidencesResponse;
use Modules\Residence\Domain\UseCases\NearestResidences\NearestResidencesPresenterContract;

final readonly class NearestResidences implements NearestResidencesContract
{
    public function __construct(
        private ResidenceRepository $repository,
    ) {
    }

    public function execute(NearestResidencesRequest $request, NearestResidencesPresenterContract $presenter): void
    {
        $response = new NearestResidencesResponse();

        $residences = $this->repository->nearest(
            location: new Location(latitude: $request->latitude, longitude: $request->longitude),
            radius: new Radius(value: $request->radius),
        );
        $response->setFailed(value: [] === $residences);
        $response->setResidences(value: $residences);

        $presenter->present(response: $response);
    }
}
