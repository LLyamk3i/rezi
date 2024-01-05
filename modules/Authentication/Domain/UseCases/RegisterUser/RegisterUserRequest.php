<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\UseCases\RegisterUser;

use Modules\Authentication\Domain\Entities\User;

final readonly class RegisterUserRequest
{
    public function __construct(
        public User $user,
    ) {
        //
    }
}
