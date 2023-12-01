<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Controllers;

use Modules\Residence\Infrastructure\Http\Responses\ResidenceResponse;
use Modules\Residence\Infrastructure\Http\Requests\SearchResidencesRequest;
use Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesContract;

final class SearchResidencesController
{
    /**
     * @see \Modules\Residence\Application\UseCases\SearchResidences
     *
     * @throws \Exception
     */
    public function __invoke(SearchResidencesRequest $request, SearchResidencesContract $useCase): ResidenceResponse
    {
        return new ResidenceResponse(
            response: $useCase->execute(request: $request->approved())
        );
    }
}
