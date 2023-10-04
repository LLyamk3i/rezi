<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Authentication\Infrastructure\Http\Requests\EmailVerificationRequest;
use Modules\Authentication\Domain\UseCases\VerifyUserAccount\VerifyUserAccountContract;

final readonly class EmailVerificationController
{
    public function __construct(
        private VerifyUserAccountContract $useCase,
    ) {
        //
    }

    public function __invoke(EmailVerificationRequest $request): JsonResponse
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
