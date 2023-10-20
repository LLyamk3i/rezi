<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Modules\Residence\Infrastructure\Models\Residence;
use Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource;

class ListResidences extends ListRecords
{
    protected static string $resource = ResidenceResource::class;

    /**
     * @return array{\Filament\Pages\Actions\CreateAction}
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
        return Residence::query();
    }
}
