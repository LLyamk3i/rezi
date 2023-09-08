<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Repositories;

use Modules\Authentication\Domain\Entities\User;

interface AccountRepository
{
    /**
     * @param array<int,\Modules\Authentication\Domain\Enums\Roles> $roles
     */
    public function create(User $user, array $roles): bool;
}
