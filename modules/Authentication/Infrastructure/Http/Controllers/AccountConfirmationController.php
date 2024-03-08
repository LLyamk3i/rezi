<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Controllers;

use Modules\Shared\Infrastructure\Http\JsonResponse;
use Modules\Authentication\Infrastructure\Http\Requests\AccountConfirmationRequest;
use Modules\Authentication\Domain\UseCases\VerifyUserAccount\VerifyUserAccountContract;

final readonly class AccountConfirmationController
{
    public function __construct(
        private VerifyUserAccountContract $verify,
    ) {
        //
    }

    /**
     * @see \Modules\Authentication\Application\UseCases\VerifyUserAccount
     *
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function __invoke(AccountConfirmationRequest $request): JsonResponse
    {
        return new JsonResponse(
            response: $this->verify->execute(request: $request->approved())
        );
    }
}
