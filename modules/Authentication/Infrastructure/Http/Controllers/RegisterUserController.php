<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Controllers;

use Modules\Shared\Infrastructure\Http\JsonResponse;
use Modules\Authentication\Infrastructure\Http\Requests\RegisterUserRequest;
use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserContract;

final class RegisterUserController
{
    /**
     * @see \Modules\Authentication\Application\UseCases\RegisterUser
     *
     * @throws \InvalidArgumentException
     */
    public function __invoke(RegisterUserRequest $request, RegisterUserContract $register): JsonResponse
    {
        return new JsonResponse(
            response: $register->execute(request: $request->approved())
        );
    }
}
