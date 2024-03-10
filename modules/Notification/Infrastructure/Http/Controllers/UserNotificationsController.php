<?php

declare(strict_types=1);

namespace Modules\Notification\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Shared\Domain\Enums\Http;

final class UserNotificationsController
{
    public function index(Request $request): JsonResponse
    {
        /** @var \Modules\Authentication\Infrastructure\Models\User $user */
        $user = $request->user();

        return response()->json(
            status: Http::OK->value,
            data: [
                'success' => true,
                'message' => trans(key: 'notification::messages.listing'),
                'notifications' => $user->notifications,
            ]
        );
    }
}
