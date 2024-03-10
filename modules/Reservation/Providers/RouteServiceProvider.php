<?php

declare(strict_types=1);

namespace Modules\Reservation\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    /**
     * @throws \RuntimeException
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->routes(routesCallback: static function (): void {
            Route::middleware('api')
                ->prefix('api/reservations')
                ->group(callback: __DIR__ . '/../routes/api.php');
        });
    }

    /**
     * @throws \RuntimeException
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for(name: 'api', callback: static fn (Request $request): Limit => Limit::perMinute(maxAttempts: 60)
            ->by(key: $request->user()?->id ?? $request->ip()));
    }
}
