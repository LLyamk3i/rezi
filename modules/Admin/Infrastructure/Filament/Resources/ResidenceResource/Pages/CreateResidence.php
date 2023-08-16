<?php

declare(strict_types=1);

namespace Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource\Pages;

use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\CreateRecord;
use Modules\Admin\Infrastructure\Filament\Resources\ResidenceResource;

/**
 * @phpstan-type ResidencePostData array{user_id:string,location:array{latitude:float,longitude:float}}
 * @phpstan-type ResidencePostDataTransformed array{user_id:string,location:\Illuminate\Contracts\Database\Query\Expression}
 */
final class CreateResidence extends CreateRecord
{
    protected static string $resource = ResidenceResource::class;

    /**
     * @phpstan-param ResidencePostData $data
     *
     * @phpstan-return ResidencePostDataTransformed
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! \is_string(value: auth()->id())) {
            throw new \UnexpectedValueException(message: 'User id must be string', code: 1);
        }

        return [
            ...$data,
            'user_id' => auth()->id(),
            'location' => DB::raw(
                value: "ST_PointFromText('POINT({$data['location']['lat']} {$data['location']['lng']})')"
            ),
        ];
    }
}
