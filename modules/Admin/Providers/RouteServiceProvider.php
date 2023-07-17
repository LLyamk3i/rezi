<?php

declare(strict_types=1);

namespace Modules\Admin\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(static function (): void {
            Route::middleware('web')
                ->name('admin.')
                ->prefix('admin')
                ->group(__DIR__ . '/../routes/web.php');
        });
    }
}
