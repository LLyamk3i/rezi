<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Tables\Columns;

use Modules\Auth\Domain\Enums\Roles;
use Filament\Tables\Columns\TextColumn;

use function Modules\Shared\Infrastructure\Helpers\string_value;

use Modules\Admin\Infrastructure\DataTransfertObjects\AuthenticatedObject;

final class ProviderColumn
{
    public static function make(): ?TextColumn
    {
        if (AuthenticatedObject::make()->role(id: string_value(value: auth()->id())) === Roles::PROVIDER) {
            return null;
        }

        return TextColumn::make(name: 'provider.name')
            ->searchable()
            ->translateLabel()
            ->toggleable(isToggledHiddenByDefault: true);
    }
}
