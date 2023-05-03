<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\LogQueriesService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

final class EloquentServiceProvider extends ServiceProvider
{
    /**
     * @var array<string,class-string>
     */
    private const MORPH_MAP = [
        'user' => \App\Models\User::class,
    ];

    public function boot(): void
    {
        Relation::enforceMorphMap(map: self::MORPH_MAP);
        Model::shouldBeStrict(shouldBeStrict: (bool) $this->app->environment('local'));
        if ((bool) $this->app->environment('local', 'testing')) {
            LogQueriesService::handle();
        }
    }
}
