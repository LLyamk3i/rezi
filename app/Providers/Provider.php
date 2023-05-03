<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

abstract class Provider extends ServiceProvider
{
    /**
     * @var array<string,array<int,class-string>>
     */
    protected array $providers = [];

    protected function providers(): void
    {
        $callback = function (string $provider): void {
            $this->app->register($provider);
        };
        array_walk(array: $this->providers['all'], callback: $callback);
        if ((bool) $this->app->environment('local')) {
            $local = $this->providers['local'] ?? [];
            array_walk(array: $local, callback: $callback);
        }
    }
}
