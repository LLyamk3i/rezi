<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

final class VisibilityColumn
{
    public static function make(string $name): TextColumn
    {
        return TextColumn::make(name: $name)
            ->badge()
            ->sortable()
            ->translateLabel()
            // ->enum(options: [false => 'désactivé', true => 'activé'])
            ->icons(icons: ['heroicon-o-x-circle' => false, 'heroicon-s-check-circle' => true])
            ->colors(colors: ['danger' => false, 'success' => true]);
    }
}
