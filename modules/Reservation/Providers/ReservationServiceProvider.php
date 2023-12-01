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
        Domain\UseCases\MakeReservation\MakeReservationContract::class => Application\UseCases\MakeReservation\MakeReservation::class,
    ];

    public function boot(): void
    {
        $this->loadMigrationsFrom(paths: __DIR__ . '/../Infrastructure/Database/Migrations');
        $this->loadTranslationsFrom(path: __DIR__ . '/../lang', namespace: 'reservation');
    }

    public function register(): void
    {
        $this->app->register(provider: \Modules\Reservation\Providers\RouteServiceProvider::class);
    }
}
