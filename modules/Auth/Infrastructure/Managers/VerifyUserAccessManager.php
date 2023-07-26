<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Managers;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Auth\Domain\Repositories\UserRoleRepository;
use Modules\Auth\Domain\DataTransferObjects\RolesGroupsObject;
use Modules\Auth\Domain\Contracts\VerifyUserAccessManagerContract;

final readonly class VerifyUserAccessManager implements VerifyUserAccessManagerContract
{
    public function __construct(
        private UserRoleRepository $repository,
        private RolesGroupsObject $groups,
    ) {
        //
    }

    public function owner(Ulid $user): bool
    {
        return $this->repository->verify(user: $user, roles: $this->groups->owner());
    }

    public function admin(Ulid $user): bool
    {
        return $this->repository->verify(user: $user, roles: $this->groups->admin());
    }

    public function provider(Ulid $user): bool
    {
        return $this->repository->verify(user: $user, roles: $this->groups->provider());
    }
}
