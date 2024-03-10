<?php

declare(strict_types=1);

namespace Modules\Notification\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Shared\Domain\Enums\Http;

final class ReadNotificationsController
{
    public function destroy(Request $request): JsonResponse
    {
        /** @var \Modules\Authentication\Infrastructure\Models\User $user */
        $user = $request->user();

        $user->unreadNotifications()->update(values: ['read_at' => now()]);

        return response()->json(
            status: Http::OK->value,
            data: [
                'success' => true,
                'message' => trans(key: 'notification::messages.read.all'),
            ]
        );
    }
}
