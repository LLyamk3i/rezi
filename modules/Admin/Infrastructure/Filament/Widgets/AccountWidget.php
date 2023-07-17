<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Widgets;

use Filament\Widgets\Widget;

class AccountWidget extends Widget
{
    protected static ?int $sort = -3;

    protected static string $view = 'filament::widgets.account-widget';
}
