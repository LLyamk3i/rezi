<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources\ProviderResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Modules\Admin\Infrastructure\Filament\Shared\Resources\ProviderResource;

final class ManageProviders extends ManageRecords
{
    protected static string $resource = ProviderResource::class;

    /**
     * @return array{}
     */
    protected function getActions(): array
    {
        return [];
    }
}
