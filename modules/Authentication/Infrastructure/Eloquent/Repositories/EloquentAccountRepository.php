<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Eloquent\Repositories;

use Modules\Authentication\Domain\Entities\User;
use Modules\Authentication\Domain\Repositories\AuthRepository;
use Modules\Authentication\Domain\Repositories\AccountRepository;

final readonly class EloquentAccountRepository implements AccountRepository
{
    public function __construct(
        private AuthRepository $repository,
    ) {
        //
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
}
