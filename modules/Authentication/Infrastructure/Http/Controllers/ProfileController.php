<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Shared\Domain\Enums\Http;
use Modules\Authentication\Infrastructure\Http\Requests\ProfileUpdateRequest;

final class ProfileController
{
    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        try {
            $request->user()?->update(attributes: $request->validated());
        } catch (\Throwable $throwable) {
            report(exception: $throwable);

            return response()->json(
                status: Http::INTERNAL_SERVER_ERROR->value,
                data: [
                    'success' => false,
                    'message' => trans(key: 'shared::messages.errors.server'),
                ]
            );
        }

        return response()->json(
            status: Http::OK->value,
            data: [
                'success' => true,
                'message' => trans(key: 'authentication::messages.profile.update'),
            ]
        );
    }
}
