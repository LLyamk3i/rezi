<?php

declare(strict_types=1);

namespace Modules\Shared\Providers;

use Modules\Shared\Domain;
use Modules\Shared\Infrastructure;
use Illuminate\Support\ServiceProvider;
use Modules\Shared\Application\Utils\Timer;
use Illuminate\Contracts\Foundation\Application;

final class SharedServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string,class-string>
     */
    public array $bindings = [
        Domain\Adapters\CacheAdapterContract::class => Infrastructure\Adapters\CacheAdapter::class,
        Domain\Adapters\UlidGeneratorAdapterContract::class => Infrastructure\Adapters\UlidGeneratorAdapter::class,
    ];

    public function register(): void
    {
        $this->app->bind(abstract: Timer::class, concrete: static function (Application $app): Timer {
            $cache = $app->get(Domain\Adapters\CacheAdapterContract::class);
            $ulid = $app->get(Domain\Adapters\UlidGeneratorAdapterContract::class);

            if ((! $cache instanceof Domain\Adapters\CacheAdapterContract) || (! $ulid instanceof Domain\Adapters\UlidGeneratorAdapterContract)) {
                throw new \TypeError(message: 'Error Processing Request');
            }

            return new Timer(cache: $cache, key: $ulid->generate());
        });
    }
}
