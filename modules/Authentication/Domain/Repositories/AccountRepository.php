<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Repositories;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Domain\Entities\User;
use Modules\Authentication\Domain\ValueObjects\Email;

interface AccountRepository
{
    public function find(Email $email): null | User;

    public function verify(Ulid $id): bool;

    /**
     * @param array<int,\Modules\Authentication\Domain\Enums\Roles> $roles
     */
    public function create(User $user, array $roles): bool;
}
