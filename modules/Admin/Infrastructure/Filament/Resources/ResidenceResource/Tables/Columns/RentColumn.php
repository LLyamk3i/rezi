<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

final class RentColumn
{
    public static function make(): TextColumn
    {
        return TextColumn::make(name: 'rent')
            ->money()
            ->searchable()
            ->sortable()
            ->translateLabel()
            ->toggleable(isToggledHiddenByDefault: true);
    }
}
