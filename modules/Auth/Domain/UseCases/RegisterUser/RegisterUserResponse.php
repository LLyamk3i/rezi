<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\UseCases\RegisterUser;

final class RegisterUserResponse
{
    public function __construct(
        public readonly bool $failed,
        public readonly string $message,
    ) {
        //
    }
}
