<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\ApplicationDependenciesService;

final class AppServiceProvider extends Provider
{
    /**
     * @var array<string,array<int,class-string>>
     */
    protected array $providers = [
        'all' => [
            \App\Providers\EloquentServiceProvider::class,
            \App\Providers\DatabaseServiceProvider::class,
        ],
        'local' => [
            \Laravel\Telescope\TelescopeServiceProvider::class,
            \App\Providers\TelescopeServiceProvider::class,
            \App\Providers\EloquentServiceProvider::class,
        ],
    ];

    public function boot(): void
    {
        ApplicationDependenciesService::context();
    }

    public function register(): void
    {
        $this->providers();
    }
}
