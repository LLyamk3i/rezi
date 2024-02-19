<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource\Tables\Actions;

use Filament\Tables\Actions\Action;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Admin\Infrastructure\Filament\Shared\Tables\Actions\ToggleVisibilityAction;

final class ToggleResidenceVisibilityAction
{
    public static function make(): Action
    {
        return ToggleVisibilityAction::make()
            ->action(action: static fn (Residence $record) => $record->visible()->toggle())
            ->modalHeading(heading: static fn (Residence $record): string => self::instruction(residence: $record))
            ->tooltip(tooltip: static fn (Residence $record): string => self::instruction(residence: $record));
    }

    /**
     * @throws \InvalidArgumentException
     */
    private static function instruction(Residence $residence): string
    {
        if ($residence->visible()->value()) {
            return trans(key: 'admin::messages.modals.disable');
        }

        return trans(key: 'admin::messages.modals.enable');
    }
}
