<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\AdminResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Admin\Infrastructure\Filament\Resources\AdminResource;

final class ListAdmins extends ListRecords
{
    protected static string $resource = AdminResource::class;

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
