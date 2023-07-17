<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Pages;

use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\CreateRecord;
use Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource;

final class CreateResidence extends CreateRecord
{
    protected static string $resource = ResidenceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $location = $data['location'];

        return [
            ...$data,
            'location' => DB::raw("ST_PointFromText('POINT({$location['latitude']} {$location['longitude']})')"),
        ];
    }
}
