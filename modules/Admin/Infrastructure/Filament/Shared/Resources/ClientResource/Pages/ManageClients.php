<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources\ClientResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Modules\Admin\Infrastructure\Filament\Shared\Resources\ClientResource;

final class ManageClients extends ManageRecords
{
    protected static string $resource = ClientResource::class;

    /**
     * @return array{}
     */
    protected function getActions(): array
    {
        return [];
    }
}
