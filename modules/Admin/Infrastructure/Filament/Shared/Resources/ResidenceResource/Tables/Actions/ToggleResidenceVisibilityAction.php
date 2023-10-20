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
            ->modalHeading(heading: 'désactivé la residence')
            ->tooltip(tooltip: static fn (Residence $record): string => ($record->visible()->value() ? 'désactive' : 'active') . ' la residence');
    }
}
