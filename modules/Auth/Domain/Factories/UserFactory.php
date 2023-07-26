<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\Factories;

use Modules\Auth\Domain\Entities\User;
use Modules\Shared\Domain\ValueObjects\Ulid;

/**
 * @phpstan-type UserRecord array{id:string,name:string,surname:string,email:string,password:string}
 */
class UserFactory
{
    /**
     * @phpstan-param UserRecord $data
     */
    public function make(array $data): User
    {
        return new User(
            id: new Ulid(value: $data['id']),
            name: $data['name'],
            surname: $data['surname'],
            email: $data['email'],
            password: $data['password']
        );
    }
}
