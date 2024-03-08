<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Factories;

use Illuminate\Support\Facades\DB;

use function Modules\Shared\Infrastructure\Helpers\can_use_spatial_index;

final class ColumnsFactory
{
    /**
     * @return array<int,string|\Illuminate\Contracts\Database\Query\Expression>
     */
    public function make(): array
    {
        return array_filter(array: [
            'residences.id', 'residences.name',
            'residences.address', 'residences.rent', 'residences.description', 'users.id as owner_id',
            'users.forename as owner_forename', 'users.surname as owner_surname', 'media.path as poster',
            can_use_spatial_index() ? DB::raw(value: 'ST_X(location) AS latitude') : null,
            can_use_spatial_index() ? DB::raw(value: 'ST_Y(location) AS longitude') : null,
        ]);
    }
}
