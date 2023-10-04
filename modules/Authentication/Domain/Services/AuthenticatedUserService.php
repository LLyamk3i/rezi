<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Services;

use Modules\Authentication\Domain\Entities\User;

interface AuthenticatedUserService
{
    public function run(): User;
}
