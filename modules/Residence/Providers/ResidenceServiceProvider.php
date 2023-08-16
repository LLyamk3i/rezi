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
        Domain\Repositories\ResidenceRepository::class => Infrastructure\Eloquent\Repositories\EloquentResidenceRepository::class,
        Domain\UseCases\NearestResidences\NearestResidencesContract::class => Application\UseCases\NearestResidences\NearestResidences::class,
        Domain\UseCases\SearchResidences\SearchResidencesContract::class => Application\UseCases\SearchResidences\SearchResidences::class,
    ];

    public function boot(): void
    {
        Relation::enforceMorphMap([
            'resi' => Infrastructure\Models\Residence::class,
        ]);
        $this->loadMigrationsFrom(paths: __DIR__ . '/../Infrastructure/Database/Migrations');
    }

    public function register(): void
    {
        $this->app->register(provider: \Modules\Residence\Providers\RouteServiceProvider::class);
    }
}
