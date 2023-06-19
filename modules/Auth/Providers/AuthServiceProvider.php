<?php

declare(strict_types=1);

namespace Modules\Auth\Providers;

use Modules\Auth\Domain;
use Modules\Auth\Application;
use Modules\Auth\Infrastructure;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string,class-string>
     */
    public array $bindings = [
        Domain\Repositories\AuthRepository::class => Infrastructure\Eloquent\Repositories\EloquentAuthRepository::class,
        Domain\UseCases\RegisterUser\RegisterUserContract::class => Application\UseCases\RegisterUser\RegisterUser::class,
    ];

    public function boot(): void
    {
        $this->loadMigrationsFrom(paths: __DIR__ . '/../Infrastructure/Database/Migrations');
    }

    public function register(): void
    {
        $this->app->register(provider: \Modules\Auth\Providers\RouteServiceProvider::class);
    }
}
