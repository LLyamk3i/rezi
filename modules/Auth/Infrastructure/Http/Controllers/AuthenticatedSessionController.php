<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Infrastructure\Models\User;
use Illuminate\Validation\ValidationException;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class AuthenticatedSessionController
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (\is_null(value: $user) || ! Hash::check(string_value(value: $request->password), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return new JsonResponse(
            status: JsonResponse::HTTP_OK,
            data: [
                'success' => true,
                'message' => "L'utilisateur s'est connecté avec succès.",
                'token' => $user->createToken(string_value(value: $request->device))->plainTextToken,
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
