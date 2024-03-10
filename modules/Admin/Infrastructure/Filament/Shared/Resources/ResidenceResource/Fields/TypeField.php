<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource\Fields;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

final class TypeField
{
    public static function make(): Select
    {
        return Select::make(name: 'type_id')
            ->relationship(name: 'type', titleAttribute: 'name')
            ->searchable()
            ->preload()
            ->required()
            ->translateLabel()
            ->createOptionForm(schema: [
                TextInput::make(name: 'name')
                    ->required()
                    ->translateLabel()
                    ->maxLength(length: 255),
            ]);
    }
}
