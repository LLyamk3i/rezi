<?php

declare(strict_types=1);

namespace Modules\Residence\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(static function (): void {
            Route::middleware('api')
                ->prefix('api/residence')
                ->group(__DIR__ . '/../routes/api.php');
        });
    }
}
