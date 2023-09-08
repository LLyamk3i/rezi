<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Modules\Authentication\Domain\Enums\Roles;
use Modules\Residence\Infrastructure\Models\Residence;

use function Modules\Shared\Infrastructure\Helpers\string_value;

use Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource;

use Modules\Admin\Infrastructure\DataTransfertObjects\AuthenticatedObject;

final class ListResidences extends ListRecords
{
    protected static string $resource = ResidenceResource::class;

    /**
     * @return array<int,\Filament\Pages\Actions\Action>
     */
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * @return Builder<Residence>
     */
    protected function getTableQuery(): Builder
    {
        $query = Residence::query();
        $user_id = string_value(value: auth()->id());
        $role = AuthenticatedObject::make()->role(id: $user_id);

        return match ($role) {
            Roles::Provider => $query->where('user_id', $user_id),
            Roles::Admin => $query,
            default => throw new \LogicException(message: "Case '{$role->value}' is not implemented.", code: 1),
        };
    }
}
