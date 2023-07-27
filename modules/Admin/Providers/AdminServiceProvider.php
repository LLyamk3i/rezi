<?php

declare(strict_types=1);

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Infrastructure\Factories\AdminLoginPageViewModelFactory;

class AdminServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(namespace: 'admin', path: __DIR__ . '/../resources/views');
    }

    public function register(): void
    {
        $this->app->register(provider: RouteServiceProvider::class);
        $this->app->register(provider: AuthServiceProvider::class);

        $this->app->singleton(abstract: \AdminLoginPageViewModel::class, concrete: static fn () => AdminLoginPageViewModelFactory::make());
    }
}
