<?php

declare(strict_types=1);

namespace Modules\Auth\Application\UseCases\RegisterUser;

final class RegisterUserJsonViewModel
{
    public function __construct(
        public readonly bool $success,
        public readonly string $message,
    ) {
        //
    }
}
