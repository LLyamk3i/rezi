<?php

declare(strict_types=1);

namespace Modules\Residence\Application\UseCases\SearchResidences;

use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesRequest;
use Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesContract;
use Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesResponse;
use Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesPresenterContract;

final readonly class SearchResidences implements SearchResidencesContract
{
    public function __construct(
        private ResidenceRepository $repository,
    ) {
        //
    }

    public function execute(SearchResidencesRequest $request, SearchResidencesPresenterContract $presenter): void
    {
        $residences = $this->repository->search(key: $request->location, stay: new Duration(
            start: $request->checkin,
            end: $request->checkout,
        ));

        if ($residences === []) {
            $presenter->present(response: new SearchResidencesResponse(
                failed: true,
                message: 'No results found for the given search parameters.',
                residences: [],
            ));

            return;
        }

        $presenter->present(response: new SearchResidencesResponse(
            failed: false,
            message: 'Search completed successfully.',
            residences: $residences,
        ));
    }
}
