<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class EloquentServiceProvider extends ServiceProvider
{
    /**
     * @var array<string,class-string>
     */
    private array $morphMap = [
        'user' => \App\Models\User::class,
    ];

    public function boot(): void
    {
        Relation::enforceMorphMap($this->morphMap);
        Model::shouldBeStrict((bool) $this->app->environment('local'));
    }
}
