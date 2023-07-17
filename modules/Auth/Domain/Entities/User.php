<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;

final class User
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
}
