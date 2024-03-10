<?php

declare(strict_types=1);

namespace Modules\Notification\Providers;

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
        Route::pattern(key: 'notification', pattern: '[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}');

        $this->configureRateLimiting();

        $this->routes(routesCallback: static function (): void {
            Route::middleware('api')
                ->prefix('api/notifications')
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
