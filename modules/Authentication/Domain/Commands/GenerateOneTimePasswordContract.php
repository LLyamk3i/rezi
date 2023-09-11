<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Commands;

interface GenerateOneTimePasswordContract
{
    public function handle(): string;
}
