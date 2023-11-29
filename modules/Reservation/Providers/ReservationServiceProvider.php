<?php

declare(strict_types=1);

namespace Modules\Reservation\Providers;

use Modules\Reservation\Domain;
use Modules\Reservation\Application;
use Illuminate\Support\ServiceProvider;
use Modules\Reservation\Infrastructure;

final class ReservationServiceProvider extends ServiceProvider
{
    /**
     * @var non-empty-array<class-string,class-string>
     */
    public array $bindings = [
        Domain\Commands\VerifyReservationOwnershipContract::class => Application\Commands\VerifyReservationOwnership::class,
        Domain\Repositories\ReservationRepository::class => Infrastructure\Eloquent\Repositories\EloquentReservationRepository::class,
        Domain\UseCases\CreateReservation\CreateReservationContract::class => Application\UseCases\CreateReservation\CreateReservation::class,
    ];

    public function boot(): void
    {
        $this->loadMigrationsFrom(paths: __DIR__ . '/../Infrastructure/Database/Migrations');
    }

    public function register(): void
    {
        $this->app->register(provider: \Modules\Reservation\Providers\RouteServiceProvider::class);
    }
}
