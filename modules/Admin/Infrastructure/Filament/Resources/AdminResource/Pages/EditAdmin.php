<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\AdminResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Admin\Infrastructure\Filament\Resources\AdminResource;

final class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    /**
     * @return array<int,\Filament\Pages\Actions\Action>
     */
    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
