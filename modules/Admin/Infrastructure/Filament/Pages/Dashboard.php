<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Pages;

use Filament\Pages\Dashboard as FilamentDashboard;

final class Dashboard extends FilamentDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-template';
}
