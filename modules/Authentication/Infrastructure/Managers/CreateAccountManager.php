<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Managers;

use Modules\Authentication\Domain\Factories\UserFactory;
use Modules\Authentication\Domain\Repositories\AccountRepository;
use Modules\Authentication\Domain\DataTransferObjects\RolesGroupsObject;
use Modules\Authentication\Domain\Contracts\CreateAccountManagerContract;

/**
 * @phpstan-import-type UserRecord from \Modules\Authentication\Domain\Factories\UserFactory
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
     *
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
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
     *
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
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
     *
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function provider(array $attributes): bool
    {
        return $this->repository->create(
            user: $this->factory->make(data: $attributes),
            roles: $this->groups->provider(),
        );
    }
}
