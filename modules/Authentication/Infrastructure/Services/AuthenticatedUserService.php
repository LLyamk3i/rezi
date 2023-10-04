<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Modules\Authentication\Domain\Entities\User;
use Modules\Authentication\Domain\Factories\UserFactory;
use Modules\Authentication\Domain\Services\AuthenticatedUserService as Contract;

/**
 * @phpstan-type UserRecord array{id:string,forename:string,surname:string,email:string,password?:string,email_verified_at:string|null}
 */
final class AuthenticatedUserService implements Contract
{
    public function __construct(
        private readonly UserFactory $factory,
        private readonly Authenticatable $user,
    ) {
        //
    }

    public function run(): User
    {
        if (! ($this->user instanceof \Modules\Authentication\Infrastructure\Models\User)) {
            throw new \RuntimeException(message: 'Account not found', code: 1);
        }
        /** @phpstan-var UserRecord $data */
        $data = $this->user->getAttributes();

        return $this->factory->make(data: $data);
    }
}
