<?php

declare(strict_types=1);

namespace Modules\Residence\Providers;

use App\Providers\Provider;
use Modules\Residence\Domain;
use Modules\Residence\Infrastructure;

final class ResidenceServiceProvider extends Provider
{
    /**
     * @var array<class-string,class-string>
     */
    public array $bindings = [
        Domain\Repositories\ResidenceRepository::class => Infrastructure\Eloquent\Repositories\EloquentResidenceRepository::class,
        Domain\UseCases\NearestResidence\NearestResidenceContract::class => Domain\UseCases\NearestResidence\NearestResidence::class,
    ];

    /**
     * @var array<string,array<int,class-string>>
     */
    protected array $providers = [
        'all' => [
            \Modules\Residence\Providers\RouteServiceProvider::class,
        ],
    ];

    public function boot(): void
    {
        $this->loadMigrationsFrom(paths: __DIR__ . '/../Infrastructure/Database/Migrations');
    }

    public function register(): void
    {
        $this->providers();
    }
}
