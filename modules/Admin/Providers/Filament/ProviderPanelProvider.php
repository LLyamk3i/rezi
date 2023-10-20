<?php

declare(strict_types=1);

namespace Modules\Admin\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;

final class ProviderPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id(id: 'provider')
            ->path(path: 'provider')
            ->login(action: \Modules\Admin\Infrastructure\Filament\Provider\Pages\Login::class)
            ->profile()
            ->authGuard(guard: 'web:provider')
            ->colors(colors: [
                'primary' => \Filament\Support\Colors\Color::Indigo,
            ])
            ->pages(pages: [
                \Modules\Admin\Infrastructure\Filament\Provider\Pages\Dashboard::class,
            ])
            ->resources(resources: [
                \Modules\Admin\Infrastructure\Filament\Shared\Resources\ClientResource::class,
                \Modules\Admin\Infrastructure\Filament\Shared\Resources\FeatureResource::class,
                \Modules\Admin\Infrastructure\Filament\Shared\Resources\ReservationResource::class,
                \Modules\Admin\Infrastructure\Filament\Provider\Resources\ResidenceResource::class,
                \Modules\Admin\Infrastructure\Filament\Shared\Resources\TypeResource::class,
            ])
            ->widgets(widgets: [
                \Filament\Widgets\AccountWidget::class,
                \Filament\Widgets\FilamentInfoWidget::class,
            ])
            ->middleware(middleware: [
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\Session\Middleware\AuthenticateSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                \Filament\Http\Middleware\DisableBladeIconComponents::class,
                \Filament\Http\Middleware\DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware(middleware: [
                \Filament\Http\Middleware\Authenticate::class,
            ]);
    }
}
