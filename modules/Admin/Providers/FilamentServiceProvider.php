<?php

declare(strict_types=1);

namespace Modules\Admin\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use function Modules\Shared\Infrastructure\Helpers\string_value;

use Modules\Admin\Infrastructure\Services\ViteManifestRetrieverService;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Filament::registerStyles(styles: [
            asset('dist/' . string_value(value: ViteManifestRetrieverService::make()->run(file: 'src/css/app.css'))),
        ]);
    }
}
