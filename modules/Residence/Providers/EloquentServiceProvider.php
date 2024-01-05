<?php

declare(strict_types=1);

namespace Modules\Residence\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

final class EloquentServiceProvider extends ServiceProvider
{
    /**
     * @throws \RuntimeException
     */
    public function boot(): void
    {
        Route::pattern(key: 'residence', pattern: '[0123456789ABCDEFGHJKMNPQRSTVWXYZabcdefghjkmnpqrstvwxyz]{26}');
    }
}
