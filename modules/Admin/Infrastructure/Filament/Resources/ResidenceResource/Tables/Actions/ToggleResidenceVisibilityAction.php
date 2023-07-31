<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Tables\Actions;

use Filament\Tables\Actions\Action;
use Modules\Auth\Domain\Enums\Roles;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Admin\Infrastructure\DataTransfertObjects\AuthenticatedObject;
use Modules\Admin\Infrastructure\Filament\Tables\Actions\ToggleVisibilityAction;

final class ToggleResidenceVisibilityAction
{
    public static function make(): ?Action
    {
        if (AuthenticatedObject::make()->role(id: auth()->id()) === Roles::PROVIDER) {
            return null;
        }

        return ToggleVisibilityAction::make()
            ->tooltip(tooltip: static fn (Residence $record): string => ($record->visible ? 'désactive' : 'active') . ' la residence')
            ->modalHeading(heading: 'désactivé la residence');
    }
}
