<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;

final readonly class User
{
    public function __construct(
        public Ulid $id,
        public string $forename,
        public string $surname,
        public string $email,
        public string $phone,
        public bool $verified = false,
        public null | string $password = null,
    ) {
        //
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'forename' => $this->forename,
            'surname' => $this->surname,
            'email' => $this->email,
            'phone' => $this->phone,
            'verified' => $this->verified,
        ];
    }
}
