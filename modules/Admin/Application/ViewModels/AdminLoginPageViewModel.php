<?php

declare(strict_types=1);

namespace Modules\Admin\Application\ViewModels;

class AdminLoginPageViewModel
{
    /**
     * @param array<string,string> $attributes
     */
    public function __construct(
        public readonly string $email,
        public readonly string $label,
        public readonly string $redirect,
        public readonly string $guard,
        public readonly array $attributes,
    ) {
        //
    }
}
