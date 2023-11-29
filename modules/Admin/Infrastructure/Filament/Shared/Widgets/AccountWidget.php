<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Widgets;

use Filament\Widgets\Widget;

final class AccountWidget extends Widget
{
    protected static null | int $sort = -3;

    protected static string $view = 'filament::widgets.account-widget';
}
