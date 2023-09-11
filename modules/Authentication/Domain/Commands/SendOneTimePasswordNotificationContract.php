<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Commands;

interface SendOneTimePasswordNotificationContract
{
    public function handle(string $code, string $email): void;
}
