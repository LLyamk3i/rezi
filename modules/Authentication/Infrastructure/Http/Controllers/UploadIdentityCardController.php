<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Authentication\Infrastructure\Http\Requests\UploadUserIdentityCardRequest;
use Modules\Authentication\Domain\UseCases\UploadIdentityCard\UploadIdentityCardContract;

/**
 * @see \Modules\Authentication\Application\UseCases\UploadIdentityCard
 */
final class UploadIdentityCardController
{
    public function __construct(
        private readonly UploadIdentityCardContract $useCase,
    ) {
        //
    }

    public function __invoke(UploadUserIdentityCardRequest $request): JsonResponse
    {
        $response = $this->useCase->execute(request: $request->approved());

        return response()->json(
            status: $response->status,
            data: [
                'success' => ! $response->failed,
                'message' => $response->message,
            ]
        );
    }
}
