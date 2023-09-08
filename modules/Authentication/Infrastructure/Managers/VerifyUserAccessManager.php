<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Managers;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Domain\Repositories\UserRoleRepository;
use Modules\Authentication\Domain\DataTransferObjects\RolesGroupsObject;
use Modules\Authentication\Domain\Contracts\VerifyUserAccessManagerContract;

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
