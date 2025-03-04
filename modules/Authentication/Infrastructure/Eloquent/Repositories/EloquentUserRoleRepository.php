<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Eloquent\Repositories;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Domain\Enums\Roles;
use Modules\Authentication\Infrastructure\Models\Role;
use Modules\Authentication\Domain\Repositories\UserRoleRepository as RepositoriesUserRoleRepository;

final class EloquentUserRoleRepository implements RepositoriesUserRoleRepository
{
    /**
     * verify if user has the ability
     *
     * @param array<int,\Modules\Authentication\Domain\Enums\Roles> $roles
     */
    public function verify(Ulid $user, array $roles): bool
    {
        if ($roles === []) {
            return false;
        }

        $results = Role::query()
            ->whereRelation(relation: 'users', column: 'id', operator: '=', value: $user->value)
            ->getQuery()
            ->pluck(column: 'name');

        if ($results->count() !== \count(value: $roles)) {
            return false;
        }

        return $results
            ->diff(items: array_map(callback: static fn (Roles $role): string => $role->value, array: $roles))
            ->isEmpty();
    }
}
