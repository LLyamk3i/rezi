<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Residence\Infrastructure\Http\Requests\NearestResidenceRequest;
use Modules\Residence\Domain\UseCases\NearestResidence\NearestResidenceContract;
use Modules\Residence\Application\UseCases\NearestResidence\NearestResidenceJsonPresenter;

final class NearestResidencesController
{
    public function index(
        NearestResidenceRequest $request,
        NearestResidenceContract $useCase,
        NearestResidenceJsonPresenter $presenter
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
