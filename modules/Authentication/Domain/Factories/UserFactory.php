<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Factories;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Domain\Entities\User;

/**
 * @phpstan-type UserRecord array{id:string,forename:string,surname:string,email:string,password:string}
 */
final class UserFactory
{
    /**
     * @phpstan-param UserRecord $data
     */
    public function make(array $data): User
    {
        return new User(
            id: new Ulid(value: $data['id']),
            forename: $data['forename'],
            surname: $data['surname'],
            email: $data['email'],
            password: $data['password']
        );
    }
}
