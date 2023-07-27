<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Factories;

use Modules\Admin\Infrastructure\Database\Records\AdminRecord;
use Modules\Auth\Infrastructure\Database\Records\ProviderRecord;
use Modules\Admin\Application\ViewModels\AdminLoginPageViewModel;

class AdminLoginPageViewModelFactory
{
    public static function make(): AdminLoginPageViewModel
    {
        $admin = ['label' => 'Login as admin', 'email' => AdminRecord::data()['email']];

        $providers = array_map(
            callback: static fn (array $record) => ['label' => 'Login as provider ' . $record['name'], 'email' => $record['email']],
            array: ProviderRecord::data(),
        );

        return new AdminLoginPageViewModel(
            fields: [$admin, ...$providers],
            redirect: '/admin',
            guard: 'web:admin',
        );
    }
}
