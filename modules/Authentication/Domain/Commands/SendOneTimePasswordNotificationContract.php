<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Commands;

use Modules\Authentication\Domain\Entities\User;

interface SendOneTimePasswordNotificationContract
{
    public function handle(string $code, User $user): void;
}
