<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

final class DateTimeColumn
{
    public static function make(string $name): TextColumn
    {
        return TextColumn::make(name: $name)
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }
}
