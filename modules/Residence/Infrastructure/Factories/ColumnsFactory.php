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
            'id', 'name', 'address', 'rent', 'description',
            can_use_spatial_index() ? DB::raw('ST_X(location) AS latitude') : null,
            can_use_spatial_index() ? DB::raw('ST_Y(location) AS longitude') : null,
        ]);
    }
}
