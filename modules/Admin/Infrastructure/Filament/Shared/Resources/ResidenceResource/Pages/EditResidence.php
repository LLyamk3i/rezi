<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\EditRecord;
use Modules\Residence\Infrastructure\Models\Residence;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource;

final class EditResidence extends EditRecord
{
    protected static string $resource = ResidenceResource::class;

    /**
     * @return array{\Filament\Pages\Actions\DeleteAction}
     */
    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException<\Illuminate\Database\Eloquent\Model>
     */
    protected function resolveRecord(int | string $key): Residence
    {
        parent::resolveRecord(key: $key);
        $record = Residence::query()->where(column: 'id', operator: '=', value: $key)
            ->first(columns: [
                '*',
                DB::raw(value: 'ST_X(location) AS latitude'),
                DB::raw(value: 'ST_Y(location) AS longitude'),
            ]);

        if ($record === null) {
            throw (new ModelNotFoundException())->setModel(model: Residence::class, ids: [$key]);
        }

        return $record;
    }

    /**
     * @param array<string,mixed> $data
     *
     * @return array<string,mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return [
            ...$data,
            'location' => ['lat' => $data['latitude'], 'lng' => $data['longitude']],
        ];
    }

    /**
     * @param array<string,mixed> $data
     *
     * @return array<string,mixed>
     *
     * @throws \Exception
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (
            \is_array(value: $data['location']) &&
            (isset($data['location']['lat']) || isset($data['location']['lng']))
        ) {
            return [...$data, 'location' => DB::raw(
                value: "ST_PointFromText('POINT({$data['location']['lat']} {$data['location']['lng']})')"
            )];
        }

        throw new \Exception(message: 'Error Processing Request', code: 1);
    }
}
