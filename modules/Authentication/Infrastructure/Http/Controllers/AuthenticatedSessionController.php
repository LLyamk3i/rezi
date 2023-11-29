<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Authentication\Infrastructure\Models\User;

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
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken(name: $request->str(key: 'device')->toString());

        return new JsonResponse(
            status: JsonResponse::HTTP_OK,
            data: [
                'success' => true,
                'message' => "L'utilisateur s'est connecté avec succès.",
                'token' => $token->plainTextToken,
            ]
        );
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->user()?->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur déconnecté.',
        ]);
    }
}
