<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Residence\Infrastructure\Resources\SearchResidencesResource;
use Modules\Residence\Infrastructure\Http\Requests\SearchResidencesRequest;
use Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesContract;
use Modules\Residence\Application\UseCases\SearchResidences\SearchResidencesJsonPresenter;

final class SearchResidencesController
{
    public function __invoke(
        SearchResidencesRequest $request,
        SearchResidencesContract $useCase,
        SearchResidencesJsonPresenter $presenter
    ): JsonResponse {
        $useCase->execute(request: $request->approved(), presenter: $presenter);

        $json = $presenter->json();

        return response()->json(
            status: $json->status,
            data: [
                'success' => $json->success,
                'message' => $json->message,
                'total' => $json->total,
                'data' => SearchResidencesResource::collection(resource: $json->data),
            ],
        );
    }
}
