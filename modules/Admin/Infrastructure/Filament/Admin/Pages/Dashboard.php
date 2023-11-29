<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Admin\Pages;

use Filament\Pages\Dashboard as FilamentDashboard;

final class Dashboard extends FilamentDashboard
{
    protected static null | string $navigationIcon = 'heroicon-o-computer-desktop';
}
