<?php

declare(strict_types=1);

namespace App\Providers;

use App\Database\ConnectionFactory;
use Illuminate\Support\ServiceProvider;

final class DatabaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // The connection factory is used to create the actual connection instances on
        // the database. We will inject the factory into the manager so that it may
        // make the connections while they are actually needed and not of before.
        $this->app->singleton('db.factory', static fn ($app): \App\Database\ConnectionFactory => new ConnectionFactory($app));
    }
}
