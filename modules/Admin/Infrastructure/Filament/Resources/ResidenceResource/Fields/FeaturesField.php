<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Fields;

use Filament\Forms\Components\Select;

final class FeaturesField
{
    public static function make(): Select
    {
        return Select::make(name: 'feature')
            ->multiple()
            ->relationship(relationshipName: 'features', titleColumnName: 'name')
            ->searchable()
            ->preload()
            ->required()
            ->translateLabel();
    }
}
