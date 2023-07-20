<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\EditRecord;
use Modules\Residence\Infrastructure\Models\Residence;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource;

final class EditResidence extends EditRecord
{
    protected static string $resource = ResidenceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function resolveRecord($key): Residence
    {
        $record = Residence::query()->where('id', $key)
            ->limit(1)
            ->get(columns: [
                '*',
                DB::raw('ST_X(location) AS latitude'),
                DB::raw('ST_Y(location) AS longitude'),
            ])
            ->first();

        if ($record === null) {
            throw (new ModelNotFoundException())->setModel($this->getModel(), [$key]);
        }

        return $record;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return [
            ...$data,
            'location' => [
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ],
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $location = $data['location'];

        return [
            ...$data,
            'location' => DB::raw("ST_PointFromText('POINT({$location['latitude']} {$location['longitude']})')"),
        ];
    }
}
