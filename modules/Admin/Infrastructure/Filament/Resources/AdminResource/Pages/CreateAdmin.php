<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\AdminResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Admin\Infrastructure\Filament\Resources\AdminResource;

final class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;
}
