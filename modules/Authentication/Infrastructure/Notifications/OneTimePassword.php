<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Illuminate\Notifications\Messages\MailMessage;

final class OneTimePassword extends Notification
{
    use \Illuminate\Bus\Queueable;

    public function __construct(
        private readonly string $otp,
    ) {
        //
    }

    /**
     * @return array<int,string>
     */
    public function via(): array
    {
        return [TwilioChannel::class];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->line(line: trans(key: 'authentication::messages.register.opt.mail'))
            ->line(line: $this->otp);
    }

    public function toTwilio(): TwilioSmsMessage
    {
        return new TwilioSmsMessage(
            content: trans(key: 'authentication::messages.register.otp.sms', replace: ['code' => $this->otp])
        );
    }
}
