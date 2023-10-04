<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\UseCases\RegisterUser;

final readonly class RegisterUserJsonViewModel
{
    public function __construct(
        public bool $success,
        public string $message,
    ) {
        //
    }
}
