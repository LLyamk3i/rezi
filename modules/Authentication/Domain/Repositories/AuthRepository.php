<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Repositories;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Domain\Entities\User;

interface AuthRepository
{
    public function register(User $user): bool;

    /**
     * @param array<int,\Modules\Authentication\Domain\Enums\Roles> $roles
     */
    public function bind(Ulid $user, array $roles): bool;
}
