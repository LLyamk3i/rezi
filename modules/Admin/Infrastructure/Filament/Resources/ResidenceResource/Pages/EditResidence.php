<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\EditRecord;
use Modules\Residence\Infrastructure\Models\Residence;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource;

/**
 * @phpstan-import-type ResidencePostData from CreateResidence
 * @phpstan-import-type ResidencePostDataTransformed from CreateResidence
 */
final class EditResidence extends EditRecord
{
    protected static string $resource = ResidenceResource::class;

    /**
     * @return array<int,\Filament\Pages\Actions\Action>
     */
    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * @param string $key
     */
    protected function resolveRecord($key): Residence
    {
        $record = Residence::query()->where('id', $key)
            ->first(columns: [
                '*',
                DB::raw('ST_X(location) AS latitude'),
                DB::raw('ST_Y(location) AS longitude'),
            ]);

        if ($record === null) {
            throw (new ModelNotFoundException())->setModel(Residence::class, [$key]);
        }

        return $record;
    }

    /**
     * @param array{user_id:string,latitude:float,longitude:float} $data
     *
     * @phpstan-return ResidencePostData
     */
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

    /**
     * @phpstan-param ResidencePostData $data
     *
     * @phpstan-return ResidencePostDataTransformed
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $location = $data['location'];

        return [
            ...$data,
            'location' => DB::raw("ST_PointFromText('POINT({$location['latitude']} {$location['longitude']})')"),
        ];
    }
}
