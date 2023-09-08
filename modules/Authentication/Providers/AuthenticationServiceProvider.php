<?php

declare(strict_types=1);

namespace Modules\Authentication\Providers;

use Modules\Authentication\Domain;
use Illuminate\Support\ServiceProvider;
use Modules\Authentication\Application;
use Modules\Authentication\Infrastructure;
use Illuminate\Database\Eloquent\Relations\Relation;

final class AuthenticationServiceProvider extends ServiceProvider
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
        $this->app->register(provider: \Modules\Authentication\Providers\RouteServiceProvider::class);
    }
}
