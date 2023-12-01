<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Modules\Shared\Domain\Enums\Http;
use Illuminate\Validation\ValidationException;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Authentication\Infrastructure\Http\Resources\UserResource;
use Modules\Authentication\Infrastructure\Http\Requests\AuthenticatedSessionRequest;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class AuthenticatedSessionController
{
    /**
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(AuthenticatedSessionRequest $request): JsonResponse
    {
        $user = User::query()->where('email', $request->input(key: 'email'))->first();

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
                'client' => new UserResource(resource: $user),
                'message' => trans(key: 'authentication::messages.login.success'),
            ]
        );
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->user()?->tokens()->delete();

        return response()->json(
            status: Http::OK->value,
            data: [
                'success' => true,
                'message' => trans(key: 'authentication::messages.disconnected'),
            ]
        );
    }
}
