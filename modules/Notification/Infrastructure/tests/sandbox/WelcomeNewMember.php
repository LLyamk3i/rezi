<?php

declare(strict_types=1);

use Illuminate\Notifications\Notification;
use Modules\Authentication\Infrastructure\Models\User;

final class WelcomeNewMember extends Notification
{
    /**
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['database'];
    }

    /**
     * @return array<string,mixed>
     */
    public function toDatabase(User $notifiable): array
    {
        return [
            'message' => 'Welcome ' . $notifiable->getAttribute(key: 'surname'),
        ];
    }
}
