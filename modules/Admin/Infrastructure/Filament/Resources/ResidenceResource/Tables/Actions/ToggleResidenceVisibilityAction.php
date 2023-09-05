<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Tables\Actions;

use Filament\Tables\Actions\Action;
use Modules\Auth\Domain\Enums\Roles;
use Modules\Residence\Infrastructure\Models\Residence;

use function Modules\Shared\Infrastructure\Helpers\string_value;

use Modules\Admin\Infrastructure\DataTransfertObjects\AuthenticatedObject;

use Modules\Admin\Infrastructure\Filament\Tables\Actions\ToggleVisibilityAction;

final class ToggleResidenceVisibilityAction
{
    public static function make(): ?Action
    {
        if (AuthenticatedObject::make()->role(id: string_value(value: auth()->id())) === Roles::Provider) {
            return null;
        }

        return ToggleVisibilityAction::make()
            ->action(action: static fn (Residence $record) => $record->visible()->toggle())
            ->modalHeading(heading: 'désactivé la residence')
            ->tooltip(tooltip: static fn (Residence $record): string => ($record->visible()->value() ? 'désactive' : 'active') . ' la residence');
    }
}
