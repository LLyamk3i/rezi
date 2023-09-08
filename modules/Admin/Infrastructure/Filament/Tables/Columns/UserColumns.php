<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

final class UserColumns
{
    /**
     * @return array<int,\Filament\Tables\Columns\Column>
     */
    public static function make(): array
    {
        return [
            TextColumn::make(name: 'forename')->searchable()->translateLabel(),
            TextColumn::make(name: 'surname')->searchable()->translateLabel(),
            TextColumn::make(name: 'email')->searchable()->translateLabel(),
            DateTimeColumn::make(name: 'email_verified_at')->translateLabel(),
            DateTimeColumn::make(name: 'created_at')->translateLabel(),
            DateTimeColumn::make(name: 'updated_at')->translateLabel(),
        ];
    }
}
