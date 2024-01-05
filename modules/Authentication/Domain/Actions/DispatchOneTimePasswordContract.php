<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Actions;

use Modules\Authentication\Domain\Entities\User;

interface DispatchOneTimePasswordContract
{
    public function execute(User $user): void;
}
