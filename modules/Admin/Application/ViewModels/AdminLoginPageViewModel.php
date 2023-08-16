<?php

declare(strict_types=1);

namespace Modules\Admin\Application\ViewModels;

final class AdminLoginPageViewModel
{
    /**
     * @param array<int,array<string,string>> $fields
     */
    public function __construct(
        public readonly array $fields,
        public readonly string $redirect,
        public readonly string $guard,
    ) {
        //
    }
}
