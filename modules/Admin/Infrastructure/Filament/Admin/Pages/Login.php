<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Admin\Pages;

use Filament\Pages\Auth\Login as FilamentLogin;

final class Login extends FilamentLogin
{
    protected static string $view = 'filament.login.admin';
}
