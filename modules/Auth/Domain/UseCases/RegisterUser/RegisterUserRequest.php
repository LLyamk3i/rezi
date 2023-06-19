<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\UseCases\RegisterUser;

use Modules\Shared\Domain\ValueObjects\Ulid;

final class RegisterUserRequest
{
    public function __construct(
        public readonly Ulid $id,
        public readonly string $name,
        public readonly string $surname,
        public readonly string $email,
        public readonly string $password,
    ) {
        //
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
