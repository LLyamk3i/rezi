<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Modules\Shared\Domain\Enums\Http;
use Illuminate\Validation\ValidationException;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Authentication\Infrastructure\Commands\UserAccountStatus;
use Modules\Authentication\Infrastructure\Http\Resources\UserResource;

use Modules\Authentication\Infrastructure\Http\Requests\AuthenticatedSessionRequest;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class AuthenticatedSessionController
{
    /**
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws ValidationException
     */
    public function store(AuthenticatedSessionRequest $request, UserAccountStatus $verification): JsonResponse
    {
        $user = User::query()->where(column: $request->access())->first();

        if (
            ! ($user instanceof User)
            || ! Hash::check(
                value: $request->str(key: 'password')->toString(),
                hashedValue: string_value(value: $user->getAttribute(key: 'password'))
            )
        ) {
            throw ValidationException::withMessages(messages: [
                'email' => [trans(key: 'authentication::messages.login.errors.credentials')],
            ]);
        }

        $token = $user->createToken(name: $request->str(key: 'device')->toString());

        return new JsonResponse(
            status: Http::OK->value,
            data: [
                'success' => true,
                'token' => $token->plainTextToken,
                'verified' => $verification->handle(user: $user),
                'message' => trans(key: 'authentication::messages.login.success'),
                'client' => new UserResource(
                    resource: $user->setHidden(hidden: ['updated_at', 'created_at', 'deleted_at', 'email_verified_at'])
                ),
            ]
        );
    }

    /**
     * @throws \RuntimeException
     */
    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! ($user instanceof User)) {
            throw new \RuntimeException(message: 'Error Processing Request', code: 1);
        }

        $user->tokens()->delete();

        return response()->json(
            status: Http::OK->value,
            data: [
                'success' => true,
                'message' => trans(key: 'authentication::messages.disconnected'),
            ]
        );
    }
}
