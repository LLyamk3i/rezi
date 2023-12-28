<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource\Pages;

use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\CreateRecord;
use Modules\Admin\Infrastructure\Filament\Shared\Resources\ResidenceResource;

final class CreateResidence extends CreateRecord
{
    protected static string $resource = ResidenceResource::class;

    /**
     * @param array<string,mixed> $data
     *
     * @return array<string,mixed>
     *
     * @throws \UnexpectedValueException
     * @throws \Exception
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! \is_string(value: auth()->id())) {
            throw new \UnexpectedValueException(message: 'User id must be string', code: 1);
        }

        if (
            \is_array(value: $data['location']) &&
            (isset($data['location']['lat']) || isset($data['location']['lng']))
        ) {
            return [...$data, 'user_id' => auth()->id(), 'location' => DB::raw(
                value: "ST_PointFromText('POINT({$data['location']['lat']} {$data['location']['lng']})')"
            )];
        }

        throw new \Exception(message: 'Error Processing Request', code: 1);
    }
}
