<?php

declare(strict_types=1);

namespace Modules\Reservation\Providers;

use App\Providers\Provider;
use Modules\Reservation\Domain;
use Modules\Reservation\Infrastructure;

final class ReservationServiceProvider extends Provider
{
    /**
     * @var array<class-string,class-string>
     */
    public array $bindings = [
        Domain\UseCases\CreateReservationContract::class => Domain\UseCases\CreateReservation::class,
        Domain\Repositories\ReservationRepository::class => Infrastructure\Eloquent\Repositories\EloquentReservationRepository::class,
    ];

    /**
     * @var array<string,array<int,class-string>>
     */
    protected array $providers = [
        'all' => [
            \Modules\Reservation\Providers\RouteServiceProvider::class,
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
