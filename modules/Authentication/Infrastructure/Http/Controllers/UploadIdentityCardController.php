<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Controllers;

use Modules\Shared\Infrastructure\Http\JsonResponse;
use Modules\Authentication\Infrastructure\Http\Requests\UploadUserIdentityCardRequest;
use Modules\Authentication\Domain\UseCases\UploadIdentityCard\UploadIdentityCardContract;

/**
 * @see \Modules\Authentication\Application\UseCases\UploadIdentityCard
 */
final readonly class UploadIdentityCardController
{
    public function __construct(
        private UploadIdentityCardContract $useCase,
    ) {
        //
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function __invoke(UploadUserIdentityCardRequest $request): JsonResponse
    {
        return new JsonResponse(
            response: $this->useCase->execute(request: $request->approved())
        );
    }
}
