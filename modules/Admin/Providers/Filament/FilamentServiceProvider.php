<?php

declare(strict_types=1);

namespace Modules\Admin\Providers\Filament;

use Filament\Support\Assets\Css;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentAsset;
use Modules\Admin\Infrastructure\Services\RegisterLoginPageViewModels;
use Modules\Admin\Infrastructure\Services\ViteManifestRetrieverService;

final class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $css = ViteManifestRetrieverService::make()->run(file: 'src/css/app.css');

        FilamentAsset::register(assets: array_filter(array: [
            \is_string(value: $css) ? Css::make(id: 'custom-stylesheet', path: asset("dist/{$css}")) : null,
        ]));
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function register(): void
    {
        $this->app->register(provider: OwnerPanelProvider::class);
        $this->app->register(provider: AdminPanelProvider::class);
        $this->app->register(provider: ProviderPanelProvider::class);

        if ($this->app->environment() === 'local') {
            /** @var RegisterLoginPageViewModels $service */
            $service = $this->app->get(id: RegisterLoginPageViewModels::class);
            $service->run();
        }
    }
}
