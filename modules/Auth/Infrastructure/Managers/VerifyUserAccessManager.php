<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Managers;

use Modules\Auth\Domain\Enums\Roles;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Auth\Domain\Repositories\UserRoleRepository;
use Modules\Auth\Domain\Contracts\VerifyUserAccessManagerContract;

final class VerifyUserAccessManager implements VerifyUserAccessManagerContract
{
    public function __construct(
        private readonly UserRoleRepository $repository,
    ) {
        //
    }

    public function owner(Ulid $user): bool
    {
        return $this->repository->verify(user: $user, roles: [
            Roles::OWNER,
            Roles::ADMIN,
            Roles::PROVIDER,
            Roles::CLIENT,
            Roles::GUEST,
        ]);
    }

    public function admin(Ulid $user): bool
    {
        return $this->repository->verify(user: $user, roles: [
            Roles::ADMIN,
            Roles::PROVIDER,
            Roles::CLIENT,
            Roles::GUEST,
        ]);
    }

    public function provider(Ulid $user): bool
    {
        return $this->repository->verify(user: $user, roles: [
            Roles::PROVIDER,
            Roles::CLIENT,
            Roles::GUEST,
        ]);
    }
}
