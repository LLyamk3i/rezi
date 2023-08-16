<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Tables\Actions;

use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Infrastructure\Enums\Libraries\Labels;

use function Modules\Shared\Infrastructure\Helpers\boolean_value;

final class ToggleVisibilityAction
{
    public static function make(): Action
    {
        return Action::make(name: 'visible')
            ->requiresConfirmation(condition: static fn (Model $record): bool => self::value(record: $record))
            ->color(color: static fn (Model $record): string => self::value(record: $record) ? 'danger' : 'success')
            ->label(label: static fn (Model $record): string => self::value(record: $record) ? Labels::Deactivated->value : Labels::Activated->value);
    }

    private static function value(Model $record): bool
    {
        return boolean_value($record->getAttribute(key: 'visible'));
    }
}
