<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\TypeResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Modules\Admin\Infrastructure\Filament\Resources\TypeResource;

final class ManageTypes extends ManageRecords
{
    protected static string $resource = TypeResource::class;

    /**
     * @return array<int,\Filament\Pages\Actions\Action>
     */
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
