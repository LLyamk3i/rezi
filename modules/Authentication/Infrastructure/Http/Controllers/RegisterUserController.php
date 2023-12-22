<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Shared\Domain\Enums\Http;
use Modules\Authentication\Infrastructure\Http\Requests\RegisterUserRequest;
use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserContract;
use Modules\Authentication\Application\UseCases\RegisterUser\RegisterUserJsonPresenter;

final class RegisterUserController
{
    /**
     * @throws \InvalidArgumentException
     */
    public function __invoke(
        RegisterUserRequest $request,
        RegisterUserContract $useCase,
        RegisterUserJsonPresenter $presenter,
    ): JsonResponse {

        $useCase->execute(request: $request->approved(), presenter: $presenter);

        $json = $presenter->viewModel();

        return new JsonResponse(
            status: $json->success ? Http::CREATED->value : Http::BAD_REQUEST->value,
            data: [
                'success' => $json->success,
                'message' => $json->message,
            ],
        );
    }
}
