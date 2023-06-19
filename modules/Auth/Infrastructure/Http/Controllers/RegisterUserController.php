<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Auth\Infrastructure\Http\Requests\RegisterUserRequest;
use Modules\Auth\Domain\UseCases\RegisterUser\RegisterUserContract;
use Modules\Auth\Application\UseCases\RegisterUser\RegisterUserJsonPresenter;

final class RegisterUserController
{
    public function __invoke(
        RegisterUserRequest $request,
        RegisterUserContract $useCase,
        RegisterUserJsonPresenter $presenter,
    ): JsonResponse {

        $useCase->execute(request: $request->approved(), presenter: $presenter);

        $json = $presenter->viewModel();

        return new JsonResponse(
            status: $json->success ? JsonResponse::HTTP_CREATED : JsonResponse::HTTP_NOT_FOUND,
            data: [
                'success' => $json->success,
                'message' => $json->message,
            ],
        );
    }
}
