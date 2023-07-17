<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\Repositories;

use Modules\Shared\Domain\ValueObjects\Ulid;

interface UserRoleRepository
{
    /**
     * @param array<int,\Modules\Auth\Domain\Enums\Roles> $roles
     */
    public function verify(Ulid $user, array $roles): bool;
}
