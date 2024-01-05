<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Commands;

use Illuminate\Support\Facades\Notification;
use Modules\Authentication\Domain\Entities\User as Entity;
use Modules\Authentication\Infrastructure\Models\User as Model;
use Modules\Authentication\Infrastructure\Notifications\OneTimePassword;
use Modules\Authentication\Domain\Commands\SendOneTimePasswordNotificationContract;

final class SendOneTimePasswordNotification implements SendOneTimePasswordNotificationContract
{
    /**
     * @throws \RuntimeException
     */
    public function handle(string $code, Entity $user): void
    {
        Notification::send(notification: new OneTimePassword(otp: $code), notifiables: new Model(attributes: [
            'id' => $user->id,
            'email' => $user->email,
            'phone' => $user->phone,
        ]));
    }
}
