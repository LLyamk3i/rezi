<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

final class ProviderColumn
{
    public static function make(): TextColumn
    {
        return TextColumn::make(name: 'provider.name')
            ->searchable()
            ->toggleable(isToggledHiddenByDefault: true)
            ->label(label: 'prestataire');
    }
}
