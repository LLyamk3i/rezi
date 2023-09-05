<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Modules\Admin\Infrastructure\Filament\Resources\UserResource;

final class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    /**
     * @return array{}
     */
    protected function getActions(): array
    {
        return [];
    }
}
