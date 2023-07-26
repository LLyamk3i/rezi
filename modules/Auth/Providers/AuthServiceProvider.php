<?php

declare(strict_types=1);

namespace Modules\Auth\Providers;

use Modules\Auth\Domain;
use Modules\Auth\Application;
use Modules\Auth\Infrastructure;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string,class-string>
     */
    public array $bindings = [
        Domain\Repositories\AuthRepository::class => Infrastructure\Eloquent\Repositories\EloquentAuthRepository::class,
        Domain\UseCases\RegisterUser\RegisterUserContract::class => Application\UseCases\RegisterUser\RegisterUser::class,
        Domain\Contracts\VerifyUserAccessManagerContract::class => Infrastructure\Managers\VerifyUserAccessManager::class,
        Domain\Contracts\CreateAccountManagerContract::class => Infrastructure\Managers\CreateAccountManager::class,
        Domain\Repositories\UserRoleRepository::class => Infrastructure\Eloquent\Repositories\EloquentUserRoleRepository::class,
        Domain\Repositories\AccountRepository::class => Infrastructure\Eloquent\Repositories\EloquentAccountRepository::class,
    ];

    public function boot(): void
    {
        Relation::enforceMorphMap([
            'user' => Infrastructure\Models\User::class,
        ]);

        $this->loadMigrationsFrom(paths: __DIR__ . '/../Infrastructure/Database/Migrations');
    }

    public function register(): void
    {
        $this->app->register(provider: \Modules\Auth\Providers\RouteServiceProvider::class);
    }
}
