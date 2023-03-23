<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\ApplicationDependenciesService;

class AppServiceProvider extends Provider
{
    /**
     * @var array<string,array<int,class-string>>
     */
    protected array $providers = [
        'all' => [
            \App\Providers\EloquentServiceProvider::class,
        ],
        'local' => [
            \Laravel\Telescope\TelescopeServiceProvider::class,
            \App\Providers\TelescopeServiceProvider::class,
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
