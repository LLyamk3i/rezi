<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Tables\Columns;

use Filament\Tables\Columns\BadgeColumn;

final class VisibilityColumn
{
    public static function make(string $name): BadgeColumn
    {
        return BadgeColumn::make(name: $name)
            ->label(label: 'visibilité')
            ->enum(options: [false => 'désactivé', true => 'activé'])
            ->icons(icons: ['heroicon-o-x-circle' => false, 'heroicon-s-check-circle' => true])
            ->colors(colors: ['danger' => false, 'success' => true]);
    }
}
