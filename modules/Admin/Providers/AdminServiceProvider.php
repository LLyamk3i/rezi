<?php

declare(strict_types=1);

namespace Modules\Admin\Providers;

use Modules\Admin\Application;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Infrastructure\Database\Records\AdminRecord;

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
            $record = AdminRecord::data();

            return new Application\ViewModels\AdminLoginPageViewModel(
                email: $record['email'],
                label: 'Login as admin',
                redirect: '/admin',
                guard: 'web:admin',
                attributes: $record,
            );
        });
    }
}
