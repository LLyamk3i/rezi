<?php

declare(strict_types=1);

namespace Modules\Admin\Application\ViewModels;

final readonly class AdminLoginPageViewModel
{
    /**
     * @param array<int,array<string,string>> $fields
     */
    public function __construct(
        public array $fields,
        public string $redirect,
        public string $guard,
    ) {
        //
    }
}
