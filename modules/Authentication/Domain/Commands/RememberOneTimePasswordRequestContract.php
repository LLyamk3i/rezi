<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Commands;

interface RememberOneTimePasswordRequestContract
{
    public function handle(string $email, string $code): void;
}
