<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Managers;

use Modules\Auth\Domain\Factories\UserFactory;
use Modules\Auth\Domain\Repositories\AccountRepository;
use Modules\Auth\Domain\DataTransferObjects\RolesGroupsObject;
use Modules\Auth\Domain\Contracts\CreateAccountManagerContract;

/**
 * @phpstan-import-type UserRecord from \Modules\Auth\Domain\Factories\UserFactory
 */
final readonly class CreateAccountManager implements CreateAccountManagerContract
{
    public function __construct(
        private UserFactory $factory,
        private AccountRepository $repository,
        private RolesGroupsObject $groups,
    ) {
        //
    }

    /**
     * @phpstan-param UserRecord $attributes
     */
    public function owner(array $attributes): bool
    {
        return $this->repository->create(
            user: $this->factory->make(data: $attributes),
            roles: $this->groups->owner(),
        );
    }

    /**
     * @phpstan-param UserRecord $attributes
     */
    public function admin(array $attributes): bool
    {
        return $this->repository->create(
            user: $this->factory->make(data: $attributes),
            roles: $this->groups->admin(),
        );
    }

    /**
     * @phpstan-param UserRecord $attributes
     */
    public function provider(array $attributes): bool
    {
        return $this->repository->create(
            user: $this->factory->make(data: $attributes),
            roles: $this->groups->provider(),
        );
    }
}
