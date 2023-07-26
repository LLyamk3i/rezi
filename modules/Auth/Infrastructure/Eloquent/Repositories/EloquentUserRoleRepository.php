<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Eloquent\Repositories;

use Modules\Auth\Domain\Enums\Roles;
use Modules\Auth\Infrastructure\Models\Role;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Auth\Domain\Repositories\UserRoleRepository as RepositoriesUserRoleRepository;

final class EloquentUserRoleRepository implements RepositoriesUserRoleRepository
{
    /**
     * verify if user has the ability
     *
     * @param array<int,\Modules\Auth\Domain\Enums\Roles> $roles
     */
    public function verify(Ulid $user, array $roles): bool
    {
        if ($roles === []) {
            return false;
        }

        $results = Role::whereRelation('users', 'id', $user->value)
            ->getQuery()
            ->pluck('name');

        if ($results->count() !== \count(value: $roles)) {
            return false;
        }

        return $results
            ->diff(array_map(callback: static fn (Roles $role) => $role->value, array: $roles))
            ->isEmpty();
    }
}
