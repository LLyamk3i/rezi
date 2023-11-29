<?php

declare(strict_types=1);

namespace Modules\Authentication\Providers;

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

        $this->routes(static function (): void {
            Route::middleware('api')
                ->prefix('api/auth')
                ->group(__DIR__ . '/../routes/api.php');
        });
    }

    /**
     * @throws \RuntimeException
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for('api', static fn (Request $request): Limit => Limit::perMinute(60)
            ->by($request->user()?->id ?? $request->ip()));
    }
}
