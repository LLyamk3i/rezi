<?php

declare(strict_types=1);

namespace Modules\Admin\Providers;

use Modules\Admin\Application;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Infrastructure\Database\Records\AdminRecord;
use Modules\Auth\Infrastructure\Database\Records\ProviderRecord;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string,class-string>
     */
    public array $bindings = [];

    public function boot(): void
    {
        $this->loadViewsFrom(namespace: 'admin', path: __DIR__ . '/../resources/views');
    }

    public function register(): void
    {
        // $this->app->register(provider: FilamentServiceProvider::class);
        $this->app->register(provider: RouteServiceProvider::class);
        $this->app->singleton(abstract: \AdminLoginPageViewModel::class, concrete: static function () {
            $admin = ['label' => 'Login as admin', 'email' => AdminRecord::data()['email']];
            $provider = ['label' => 'Login as provider', 'email' => ProviderRecord::data()['email']];

            return new Application\ViewModels\AdminLoginPageViewModel(
                fields: [$admin, $provider],
                redirect: '/admin',
                guard: 'web:admin',
            );
        });
    }
}
