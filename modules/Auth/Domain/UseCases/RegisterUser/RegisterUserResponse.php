<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\UseCases\RegisterUser;

final readonly class RegisterUserResponse
{
    public function __construct(
        public bool $failed,
        public string $message,
    ) {
        //
    }
}
