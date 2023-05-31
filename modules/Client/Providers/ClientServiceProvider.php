<?php

declare(strict_types=1);

namespace Modules\Client\Providers;

use Modules\Client\Domain;
use App\Providers\Provider;
use Modules\Client\Infrastructure;
use Illuminate\Support\ServiceProvider;

final class ClientServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string,class-string>
     */
    public array $bindings = [
        // Domain\Repositories\ClientRepository::class => Infrastructure\Eloquent\Repositories\EloquentClientRepository::class,
        // Domain\UseCases\NearestClient\NearestClientContract::class => Domain\UseCases\NearestClient\NearestClient::class,
    ];

    public function boot(): void
    {
        $this->loadMigrationsFrom(paths: __DIR__ . '/../Infrastructure/Database/Migrations');
    }

    public function register(): void
    {
        // $this->app->register(provider:\Modules\Client\Providers\RouteServiceProvider::class);
    }
}
