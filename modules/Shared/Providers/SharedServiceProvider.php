<?php

declare(strict_types=1);

namespace Modules\Shared\Providers;

use Modules\Shared\Domain;
use Modules\Shared\Application;
use Symfony\Component\Uid\Ulid;
use Modules\Shared\Infrastructure;
use Illuminate\Support\ServiceProvider;
use Modules\Shared\Application\Utils\Timer;
use Modules\Shared\Application\Commands\GenerateUlid;
use Modules\Shared\Domain\Repositories\MediaRepository;
use Modules\Shared\Domain\Commands\GenerateUlidContract;
use Illuminate\Contracts\Foundation\Application as Laravel;
use Modules\Shared\Infrastructure\Generators\UlidGenerator;
use Modules\Shared\Infrastructure\Eloquent\Repositories\EloquentMediaRepository;

final class SharedServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string,class-string>
     */
    public array $bindings = [
        Domain\Adapters\CacheAdapterContract::class => Infrastructure\Adapters\CacheAdapter::class,
        Application\Repositories\Repository::class => Infrastructure\Repositories\QueryRepository::class,
    ];

    /**
     * @var array<class-string,class-string>
     */
    public array $singletons = [
        Domain\Contracts\StoreContract::class => Infrastructure\Supports\Store::class,
    ];

    public function boot(): void
    {
        $this->loadMigrationsFrom(paths: __DIR__ . '/../Infrastructure/Database/Migrations');
        $this->loadTranslationsFrom(path: __DIR__ . '/../lang', namespace: 'shared');
    }

    public function register(): void
    {
        $this->app->bind(abstract: MediaRepository::class, concrete: static fn (): EloquentMediaRepository => new EloquentMediaRepository(ulid: new UlidGenerator()));
        $this->app->bind(abstract: GenerateUlidContract::class, concrete: static fn (): GenerateUlid => new GenerateUlid(generator: new UlidGenerator()));
        $this->app->bind(abstract: Timer::class, concrete: static function (Laravel $app): Timer {
            $cache = $app->get(Domain\Adapters\CacheAdapterContract::class);

            if ((! $cache instanceof Domain\Adapters\CacheAdapterContract)) {
                throw new \TypeError(message: 'Error Processing Request');
            }

            return new Timer(cache: $cache, key: Ulid::generate());
        });
    }
}
