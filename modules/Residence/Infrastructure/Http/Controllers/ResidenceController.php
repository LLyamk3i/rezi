<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Shared\Domain\ValueObjects\Pagination\Page;
use Modules\Residence\Infrastructure\Http\Responses\ResidencesResponse;
use Modules\Residence\Domain\UseCases\ListResidences\ListResidencesRequest;
use Modules\Residence\Domain\UseCases\ListResidences\ListResidencesContract;

final class ResidenceController
{
    /**
     * @see \Modules\Residence\Application\UseCases\ListResidences
     *
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function index(Request $request, ListResidencesContract $useCase): ResidencesResponse
    {
        return new ResidencesResponse(
            response: $useCase->execute(request: new ListResidencesRequest(
                page: new Page(
                    current: $request->integer(key: 'page', default: 1),
                    per: $request->integer(key: 'per_page', default: 20)
                )
            ))
        );
    }
}
