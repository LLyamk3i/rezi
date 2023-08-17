<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ApplicationDependenciesService;

final class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        ApplicationDependenciesService::context();
    }

    public function register(): void
    {
        $this->app->register(provider: \App\Providers\EloquentServiceProvider::class);
        $this->app->register(provider: \App\Providers\DatabaseServiceProvider::class);

        if (\boolval(value: $this->app->environment('production'))) {
            return;
        }

        if (class_exists(class: \Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(provider: \Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(provider: \App\Providers\TelescopeServiceProvider::class);
        }
    }
}
