<?php

declare(strict_types=1);

namespace Modules\Admin\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;

final class OwnerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id(id: 'owner')
            ->path(path: 'owner')
            ->login(action: \Modules\Admin\Infrastructure\Filament\Owner\Pages\Login::class)
            ->profile()
            ->authGuard(guard: 'web:owner')
            ->colors(colors: [
                'primary' => \Filament\Support\Colors\Color::Lime,
            ])
            ->pages(pages: [
                \Modules\Admin\Infrastructure\Filament\Owner\Pages\Dashboard::class,
            ])
            ->resources(resources: [])
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
