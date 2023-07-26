<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\UseCases\RegisterUser;

use Modules\Shared\Domain\ValueObjects\Ulid;

final readonly class RegisterUserRequest
{
    public function __construct(
        public Ulid $id,
        public string $name,
        public string $surname,
        public string $email,
        public string $password,
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
