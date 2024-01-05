<?php

declare(strict_types=1);

namespace Modules\Residence\Providers;

use Modules\Residence\Domain;
use Modules\Residence\Application;
use Modules\Residence\Infrastructure;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

final class ResidenceServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string,class-string>
     */
    public array $bindings = [
        Domain\UseCases\ShowResidence\ShowResidenceContract::class => Application\UseCases\ShowResidence::class,
        Domain\UseCases\ListResidences\ListResidencesContract::class => Application\UseCases\ListResidences::class,
        Domain\UseCases\SearchResidences\SearchResidencesContract::class => Application\UseCases\SearchResidences::class,
        Domain\UseCases\NearestResidences\NearestResidencesContract::class => Application\UseCases\NearestResidences::class,
        Domain\Repositories\ResidenceRepository::class => Infrastructure\Eloquent\Repositories\EloquentResidenceRepository::class,
    ];

    public function boot(): void
    {
        Relation::enforceMorphMap([
            'feat' => Infrastructure\Models\Feature::class,
            'resi' => Infrastructure\Models\Residence::class,
        ]);
        $this->loadTranslationsFrom(path: __DIR__ . '/../lang', namespace: 'residence');
        $this->loadMigrationsFrom(paths: __DIR__ . '/../Infrastructure/Database/Migrations');
    }

    public function register(): void
    {
        $this->app->register(provider: EloquentServiceProvider::class);
        $this->app->register(provider: RouteServiceProvider::class);
    }
}
