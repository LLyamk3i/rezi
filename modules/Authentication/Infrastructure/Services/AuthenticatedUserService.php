<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Modules\Authentication\Domain\Entities\User;
use Modules\Authentication\Domain\Factories\UserFactory;
use Modules\Authentication\Domain\Services\AuthenticatedUserService as Contract;

/**
 * @phpstan-type UserRecord array{id:string,forename:string,surname:string,phone:string,email:string,password?:string,email_verified_at:string|null}
 */
final readonly class AuthenticatedUserService implements Contract
{
    public function __construct(
        private UserFactory $factory,
        private Authenticatable $user,
    ) {
        //
    }

    /**
     * @throws \RuntimeException
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
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
