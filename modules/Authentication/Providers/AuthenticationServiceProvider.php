<?php

declare(strict_types=1);

namespace Modules\Authentication\Providers;

use Modules\Authentication\Domain;
use Illuminate\Support\ServiceProvider;
use Modules\Authentication\Application;
use Modules\Authentication\Infrastructure;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Authentication\Application\Generators\NumberGenerator;
use Modules\Authentication\Application\Commands\GenerateOneTimePassword;
use Modules\Authentication\Domain\Commands\GenerateOneTimePasswordContract;

final class AuthenticationServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string,class-string>
     */
    public array $bindings = [
        Domain\Services\AuthenticatedUserService::class => Infrastructure\Services\AuthenticatedUserService::class,
        Domain\Actions\DispatchOneTimePasswordContract::class => Application\Actions\DispatchOneTimePassword::class,
        Domain\Contracts\CreateAccountManagerContract::class => Infrastructure\Managers\CreateAccountManager::class,
        Domain\Repositories\AuthRepository::class => Infrastructure\Eloquent\Repositories\EloquentAuthRepository::class,
        Domain\Contracts\VerifyUserAccessManagerContract::class => Infrastructure\Managers\VerifyUserAccessManager::class,
        Domain\UseCases\RegisterUser\RegisterUserContract::class => Application\UseCases\RegisterUser\RegisterUser::class,
        Domain\Commands\RetrievesOneTimePasswordContract::class => Infrastructure\Commands\RetrievesOneTimePassword::class,
        Domain\UseCases\VerifyUserAccount\VerifyUserAccountContract::class => Application\UseCases\VerifyUserAccount::class,
        Domain\Repositories\AccountRepository::class => Infrastructure\Eloquent\Repositories\EloquentAccountRepository::class,
        Domain\UseCases\UploadIdentityCard\UploadIdentityCardContract::class => Application\UseCases\UploadIdentityCard::class,
        Domain\Repositories\UserRoleRepository::class => Infrastructure\Eloquent\Repositories\EloquentUserRoleRepository::class,
        Domain\Commands\RememberOneTimePasswordRequestContract::class => Infrastructure\Commands\RememberOneTimePasswordRequest::class,
        Domain\Commands\SendOneTimePasswordNotificationContract::class => Infrastructure\Commands\SendOneTimePasswordNotification::class,
    ];

    public function boot(): void
    {
        Relation::enforceMorphMap([
            'user' => Infrastructure\Models\User::class,
        ]);

        $this->loadMigrationsFrom(paths: __DIR__ . '/../Infrastructure/Database/Migrations');
        $this->loadTranslationsFrom(path: __DIR__ . '/../lang', namespace: 'authentication');
    }

    public function register(): void
    {
        $this->app->bind(abstract: GenerateOneTimePasswordContract::class, concrete: static fn (): GenerateOneTimePassword => new GenerateOneTimePassword(generator: new NumberGenerator()));
        $this->app->register(provider: \Modules\Authentication\Providers\RouteServiceProvider::class);
    }
}
