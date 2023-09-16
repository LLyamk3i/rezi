<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Domain\Entities\User;
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
        private AuthRepository $repository,
    ) {
        //
    }

    public function find(Ulid $id): ?User
    {
        /** @phpstan-var UserRecord|null $result */
        $result = DB::table(table: 'users')
            ->where('id', $id->value)
            ->limit(value: 1)
            ->get()
            ->first();

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
            return $this->repository->register(user: $user)
                && $this->repository->bind(user: $user->id, roles: $roles);
        } catch (\Throwable $th) {
            report(exception: $th);

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
