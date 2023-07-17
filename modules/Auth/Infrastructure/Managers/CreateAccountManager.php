<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Managers;

use Modules\Auth\Domain\Enums\Roles;
use Modules\Auth\Domain\Entities\User;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Symfony\Component\Uid\Ulid as SymfonyUlid;
use Modules\Auth\Domain\Repositories\AccountRepository;
use Modules\Auth\Domain\Contracts\CreateAccountManagerContract;

final class CreateAccountManager implements CreateAccountManagerContract
{
    public function __construct(
        private readonly AccountRepository $repository,
    ) {
        //
    }

    /**
     * @param array{id?:Ulid,name:string,surname:string,email:string,password:string} $attributes
     */
    public function owner(array $attributes): bool
    {
        return $this->repository->create(
            user: new User(...$this->wrap(attributes: $attributes)),
            roles: [
                Roles::OWNER,
                Roles::ADMIN,
                Roles::PROVIDER,
                Roles::CLIENT,
                Roles::GUEST,
            ]
        );
    }

    /**
     * @param array{id?:Ulid,name:string,surname:string,email:string,password:string} $attributes
     */
    public function admin(array $attributes): bool
    {
        return $this->repository->create(
            user: new User(...$this->wrap(attributes: $attributes)),
            roles: [
                Roles::ADMIN,
                Roles::PROVIDER,
                Roles::CLIENT,
                Roles::GUEST,
            ]
        );
    }

    /**
     * @param array{id?:Ulid,name:string,surname:string,email:string,password:string} $attributes
     */
    public function provider(array $attributes): bool
    {
        return $this->repository->create(
            user: new User(...$this->wrap(attributes: $attributes)),
            roles: [
                Roles::PROVIDER,
                Roles::CLIENT,
                Roles::GUEST,
            ]
        );
    }

    /**
     * @template T of array
     *
     * @phpstan-param T $attributes
     *
     * @phpstan-return T
     */
    private function wrap(array $attributes): array
    {
        return isset($attributes['id'])
            ? $attributes
            : [...$attributes, 'id' => new Ulid(value: SymfonyUlid::generate())];
    }
}
