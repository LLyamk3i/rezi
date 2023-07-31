<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Tables\Actions;

use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

final class ToggleVisibilityAction
{
    public static function make(): ?Action
    {
        return Action::make(name: 'visible')
            ->label(label: static fn (Model $record): string => $record->visible ? 'désactivé' : 'activé')
            ->requiresConfirmation(condition: static fn (Model $record): bool => $record->visible)
            ->action(action: static fn (Model $record) => $record->update(attributes: ['visible' => ! $record->visible]))
            ->color(color: static fn (Model $record): string => $record->visible ? 'danger' : 'success');
    }
}
