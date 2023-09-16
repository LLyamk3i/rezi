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
        public string $password,
        public bool $verified = false,
    ) {
        //
    }
}
