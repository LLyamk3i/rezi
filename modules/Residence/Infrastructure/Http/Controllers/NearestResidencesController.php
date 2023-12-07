<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Controllers;

use Modules\Residence\Infrastructure\Http\Responses\ResidenceResponse;
use Modules\Residence\Infrastructure\Http\Requests\NearestResidencesRequest;
use Modules\Residence\Domain\UseCases\NearestResidences\NearestResidencesContract;

/**
 * @see \Modules\Residence\Application\UseCases\NearestResidences
 */
final class NearestResidencesController
{
    /**
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function __invoke(NearestResidencesRequest $request, NearestResidencesContract $useCase): ResidenceResponse
    {
        return new ResidenceResponse(
            response: $useCase->execute(request: $request->approved())
        );
    }
}
