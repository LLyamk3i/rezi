<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Controllers;

use Modules\Shared\Infrastructure\Http\JsonResponse;
use Modules\Authentication\Infrastructure\Http\Requests\EmailVerificationRequest;
use Modules\Authentication\Domain\UseCases\VerifyUserAccount\VerifyUserAccountContract;

final readonly class EmailVerificationController
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
    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        return new JsonResponse(
            response: $this->verify->execute(request: $request->approved())
        );
    }
}
