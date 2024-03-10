<?php

declare(strict_types=1);

use Illuminate\Notifications\Notification;
use Modules\Authentication\Infrastructure\Models\User;

final class InvoicePaid extends Notification
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
            'message' => 'thank ' . $notifiable->getAttribute(key: 'surname') . ' for  your payment',
        ];
    }
}
