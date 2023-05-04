<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\LogQueriesService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

final class EloquentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Model::shouldBeStrict(shouldBeStrict: (bool) $this->app->environment('local'));
        if ((bool) $this->app->environment('local', 'testing')) {
            LogQueriesService::handle();
        }
    }
}
