<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Commands;

interface RetrievesOneTimePasswordContract
{
    public function handle(string $email): string;
}
