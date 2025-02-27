<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Tables\Actions;

use Filament\Tables\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Model;

use Modules\Admin\Infrastructure\Enums\Libraries\Labels;

use function Modules\Shared\Infrastructure\Helpers\boolean_value;

final class ToggleVisibilityAction
{
    public static function make(): Action
    {
        return Action::make(name: 'visible')
            ->modalWidth(width: MaxWidth::Small)
            ->requiresConfirmation(condition: static fn (Model $record): bool => self::value(record: $record))
            ->color(color: static fn (Model $record): string => self::value(record: $record) ? 'danger' : 'success')
            ->label(label: static fn (Model $record): string => self::value(record: $record) ? Labels::Deactivated->value : Labels::Activated->value);
    }

    /**
     * @throws \InvalidArgumentException
     */
    private static function value(Model $record): bool
    {
        return boolean_value($record->getAttribute(key: 'visible'));
    }
}
