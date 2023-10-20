<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources\FeatureResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Modules\Admin\Infrastructure\Filament\Shared\Resources\FeatureResource;

final class ManageFeatures extends ManageRecords
{
    protected static string $resource = FeatureResource::class;

    /**
     * @return array<int,\Filament\Pages\Actions\CreateAction>
     */
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
