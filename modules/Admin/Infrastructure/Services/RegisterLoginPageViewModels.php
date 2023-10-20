<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Services;

use Modules\Shared\Domain\Contracts\StoreContract;
use Modules\Admin\Application\ViewModels\LoginPageViewModel;
use Modules\Admin\Infrastructure\Database\Records\AdminRecord;
use Modules\Admin\Infrastructure\Database\Records\OwnerRecord;
use Modules\Admin\Infrastructure\Database\Records\ProviderRecord;

final class RegisterLoginPageViewModels
{
    public function __construct(
        private readonly StoreContract $store,
    ) {
        //
    }

    public function run(): void
    {
        $this->store->put(key: 'view-models.owner', value: static fn (): LoginPageViewModel => new LoginPageViewModel(
            label: 'Login as owner',
            redirect: '/owner',
            guard: 'web:owner',
            email: OwnerRecord::data()['email'],
        ));
        $this->store->put(key: 'view-models.admin', value: static fn (): LoginPageViewModel => new LoginPageViewModel(
            label: 'Login as admin',
            redirect: '/admin',
            guard: 'web:admin',
            email: AdminRecord::data()['email'],
        ));

        $this->store->put(key: 'view-models.providers', value: static function (): array {
            return array_map(
                callback: static fn (array $record): LoginPageViewModel => new LoginPageViewModel(
                    email: $record['email'],
                    redirect: '/provider',
                    guard: 'web:provider',
                    label: 'Login as provider ' . $record['surname'],
                ),
                array: ProviderRecord::data()
            );
        });
    }
}
