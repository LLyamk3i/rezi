<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Commands;

use Illuminate\Support\Facades\Cache;
use Modules\Authentication\Domain\Commands\RememberOneTimePasswordRequestContract;

final class RememberOneTimePasswordRequest implements RememberOneTimePasswordRequestContract
{
    public function handle(string $email, string $code): void
    {
        Cache::remember(
            key: "{$email}-otp",
            ttl: (60 * 15), // 15 minutes,
            callback: static fn (): array => ['email' => $email, 'code' => $code],
        );
    }
}
