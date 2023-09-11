<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Commands;

use Illuminate\Support\Facades\Notification;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Authentication\Infrastructure\Notifications\OneTimePassword;
use Modules\Authentication\Domain\Commands\SendOneTimePasswordNotificationContract;

final class SendOneTimePasswordNotification implements SendOneTimePasswordNotificationContract
{
    public function handle(string $code, string $email): void
    {
        $user = new User(attributes: ['email' => $email]);

        Notification::send(
            notifiables: $user,
            notification: new OneTimePassword(code: $code)
        );
    }
}
