<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Domain\Entities\User;
use Modules\Authentication\Domain\ValueObjects\Email;
use Modules\Shared\Application\Repositories\Repository;
use Modules\Authentication\Domain\Factories\UserFactory;
use Modules\Authentication\Domain\Repositories\AuthRepository;
use Modules\Authentication\Domain\Repositories\AccountRepository;

/**
 * @phpstan-import-type UserRecord from \Modules\Authentication\Domain\Factories\UserFactory
 */
final readonly class EloquentAccountRepository implements AccountRepository
{
    public function __construct(
        private UserFactory $factory,
        private Repository $parent,
        private AuthRepository $repository,
    ) {
        //
    }

    /**
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function find(Email $email): null | User
    {
        /** @phpstan-var UserRecord|null $result */
        $result = $this->parent->find(
            columns: ['*'],
            query: DB::table(table: 'users')->where('email', $email->value),
        );

        return \is_array(value: $result)
            ? $this->factory->make(data: $result)
            : null;
    }

    /**
     * @param array<int,\Modules\Authentication\Domain\Enums\Roles> $roles
     */
    public function create(User $user, array $roles): bool
    {
        if ($roles === []) {
            return false;
        }

        try {
            if (! $this->repository->register(user: $user)) {
                return false;
            }

            return $this->repository->bind(user: $user->id, roles: $roles);
        } catch (\Throwable $throwable) {
            report(exception: $throwable);

            return false;
        }
    }

    public function verify(Ulid $id): bool
    {
        $affected = DB::table(table: 'users')
            ->where('id', $id->value)
            ->update(values: ['email_verified_at' => (string) now()]);

        return $affected === 1;
    }
}
