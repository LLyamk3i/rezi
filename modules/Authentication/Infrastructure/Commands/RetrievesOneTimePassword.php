<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Commands;

use Illuminate\Support\Facades\Cache;
use Modules\Authentication\Domain\Commands\RetrievesOneTimePasswordContract;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class RetrievesOneTimePassword implements RetrievesOneTimePasswordContract
{
    /**
     * @throws \InvalidArgumentException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function handle(string $email): string
    {
        return string_value(value: Cache::get(key: "{$email}-one-time-password"));
    }
}
