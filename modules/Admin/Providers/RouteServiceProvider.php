<?php

declare(strict_types=1);

namespace Modules\Admin\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(routesCallback: static function (): void {
            Route::middleware('web')
                ->name('admin.')
                ->prefix('admin')
                ->group(callback: __DIR__ . '/../routes/web.php');
        });
    }
}
