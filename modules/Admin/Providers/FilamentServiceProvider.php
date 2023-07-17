<?php

declare(strict_types=1);

namespace Modules\Admin\Providers;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentServiceProvider extends PluginServiceProvider
{
    protected array $beforeCoreScripts = [];

    public function boot(): void
    {
        $manifest = json_decode(
            json: file_get_contents(filename: __DIR__ . '/../resources/frontend/dist/build/manifest.json'),
            associative: true,
        );
        $this->beforeCoreScripts['admin-scripts'] = $manifest['src/js/app.ts']['file'];
    }

    public function configurePackage(Package $package): void
    {
        $package->name('modules:admin');
    }
}
