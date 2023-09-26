<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Modules\Authentication\Domain\Enums\Roles;

use Modules\Admin\Infrastructure\DataTransfertObjects\AuthenticatedObject;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class ProviderColumn
{
    public static function make(): ?TextColumn
    {
        if (AuthenticatedObject::make()->role(id: string_value(value: auth()->id())) === Roles::Provider) {
            return null;
        }

        return TextColumn::make(name: 'provider.name')
            ->searchable()
            ->translateLabel()
            ->toggleable(isToggledHiddenByDefault: true);
    }
}
