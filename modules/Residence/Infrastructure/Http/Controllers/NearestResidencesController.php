<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Residence\Infrastructure\Http\Requests\NearestResidencesRequest;
use Modules\Residence\Domain\UseCases\NearestResidences\NearestResidencesContract;
use Modules\Residence\Application\UseCases\NearestResidences\NearestResidencesJsonPresenter;

final class NearestResidencesController
{
    public function __invoke(
        NearestResidencesRequest $request,
        NearestResidencesContract $useCase,
        NearestResidencesJsonPresenter $presenter
    ): JsonResponse {
        $useCase->execute(request: $request->approved(), presenter: $presenter);

        $json = $presenter->view();

        return response()->json(
            status: $json->status,
            data: [
                'success' => $json->success,
                'message' => $json->message,
                'data' => $json->data,
            ],
        );
    }
}
