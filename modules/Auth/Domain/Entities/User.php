<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;

final readonly class User
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
}
