<?php

declare(strict_types=1);

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Providers\Filament\FilamentServiceProvider;

final class AdminServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(namespace: 'admin', path: __DIR__ . '/../resources/views');
        $this->loadTranslationsFrom(path: __DIR__ . '/../lang', namespace: 'admin');
    }

    public function register(): void
    {
        $this->app->register(provider: RouteServiceProvider::class);
        $this->app->register(provider: AuthServiceProvider::class);
        $this->app->register(provider: FilamentServiceProvider::class);
    }
}
