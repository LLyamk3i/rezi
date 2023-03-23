<?php

declare(strict_types=1);

namespace Modules\Client\Providers;

use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider as ParentServiceProvider;

class RouteServiceProvider extends ParentServiceProvider
{
    public function boot(): void
    {
        $this->routes(static function (): void {
            Route::middleware('api')
                ->prefix('api/client')
                ->group(__DIR__ . '/../routes/api.php');
        });
    }
}
