<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\Repositories;

use Modules\Auth\Domain\Entities\User;
use Modules\Shared\Domain\ValueObjects\Ulid;

interface AuthRepository
{
    public function register(User $user): bool;

    /**
     * @param array<int,\Modules\Auth\Domain\Enums\Roles> $roles
     */
    public function bind(Ulid $user, array $roles): bool;
}
