<?php

namespace Modules\Client\Providers;

use App\Providers\Provider;

class ClientServiceProvider extends Provider
{
    /**
     * @var array<string,array<int,class-string>>
     */
    protected array $providers = [
        'all' => [
            \Modules\Client\Providers\RouteServiceProvider::class
        ]
    ];

    public function boot(): void
    {
        $this->loadRoutesFrom(path: __DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(paths: __DIR__ . '/../Infrastructure/Database/Migrations');
    }

    public function register(): void
    {
        $this->providers();
    }
}
