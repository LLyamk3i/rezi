<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Actions;

interface DispatchOneTimePasswordContract
{
    public function execute(string $email): void;
}
