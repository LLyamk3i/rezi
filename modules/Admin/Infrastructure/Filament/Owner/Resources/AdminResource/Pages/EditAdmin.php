<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Owner\Resources\AdminResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Admin\Infrastructure\Filament\Owner\Resources\AdminResource;

final class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    /**
     * @return array{\Filament\Pages\Actions\DeleteAction}
     */
    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
