<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\Repositories;

use Modules\Shared\Domain\ValueObjects\Ulid;

interface AuthRepository
{
    public function register(Ulid $id, string $name, string $surname, string $email, string $password): bool;

    /**
     * @param array<int,string> $roles
     */
    public function bind(Ulid $user, array $roles): bool;
}
