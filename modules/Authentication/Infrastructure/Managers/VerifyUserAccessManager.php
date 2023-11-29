<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Managers;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\Contracts\StoreContract;
use Modules\Authentication\Domain\Repositories\UserRoleRepository;
use Modules\Authentication\Domain\DataTransferObjects\RolesGroupsObject;
use Modules\Authentication\Domain\Contracts\VerifyUserAccessManagerContract;

use function Modules\Shared\Infrastructure\Helpers\boolean_value;

final readonly class VerifyUserAccessManager implements VerifyUserAccessManagerContract
{
    public function __construct(
        private StoreContract $store,
        private RolesGroupsObject $groups,
        private UserRoleRepository $repository,
    ) {
        //
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function owner(Ulid $user): bool
    {
        return $this->verify(user: $user, role: 'owner', roles: $this->groups->owner());
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function admin(Ulid $user): bool
    {
        return $this->verify(user: $user, role: 'admin', roles: $this->groups->admin());
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function provider(Ulid $user): bool
    {
        return $this->verify(user: $user, role: 'provider', roles: $this->groups->provider());
    }

    /**
     * @param array<int,\Modules\Authentication\Domain\Enums\Roles> $roles
     *
     * @throws \InvalidArgumentException
     */
    private function verify(Ulid $user, string $role, array $roles): bool
    {
        return boolean_value(value: $this->store->remember(
            key: "users/{$user}<=>roles/{$role}",
            callback: fn (): bool => $this->repository->verify(user: $user, roles: $roles)
        ));
    }
}
