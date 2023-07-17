<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\Repositories;

use Modules\Auth\Domain\Entities\User;

interface AccountRepository
{
    /**
     * @param array<int,\Modules\Auth\Domain\Enums\Roles> $roles
     */
    public function create(User $user, array $roles): bool;
}
