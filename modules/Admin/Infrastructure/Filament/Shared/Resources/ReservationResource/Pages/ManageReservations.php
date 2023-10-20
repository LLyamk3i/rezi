<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources\ReservationResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Modules\Admin\Infrastructure\Filament\Shared\Resources\ReservationResource;

final class ManageReservations extends ManageRecords
{
    protected static string $resource = ReservationResource::class;

    /**
     * @return array{}
     */
    protected function getActions(): array
    {
        return [];
    }
}
