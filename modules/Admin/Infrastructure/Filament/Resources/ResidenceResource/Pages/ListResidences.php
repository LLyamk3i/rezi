<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Pages;

use Filament\Pages\Actions;
use Modules\Auth\Domain\Enums\Roles;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Modules\Residence\Infrastructure\Models\Residence;
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

    protected function getTableQuery(): Builder
    {
        $query = Residence::query();
        $user_id = auth()->id();

        return match (AuthenticatedObject::make()->role(id: $user_id)) {
            Roles::PROVIDER => $query->where('user_id', $user_id),
            Roles::ADMIN => $query,
        };
    }
}
