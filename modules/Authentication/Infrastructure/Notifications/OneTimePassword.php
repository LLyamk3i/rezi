<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

final class OneTimePassword extends Notification
{
    use \Illuminate\Bus\Queueable;

    public function __construct(
        private readonly string $code,
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int,string>
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->line(line: "Veuillez vérifier votre adresse électronique à l'aide du code suivant :")
            ->line(line: $this->code);
    }
}
