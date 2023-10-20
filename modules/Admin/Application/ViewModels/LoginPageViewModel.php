<?php

declare(strict_types=1);

namespace Modules\Admin\Application\ViewModels;

final readonly class LoginPageViewModel
{
    public function __construct(
        public string $label,
        public string $email,
        public string $redirect,
        public string $guard,
    ) {
        //
    }
}
