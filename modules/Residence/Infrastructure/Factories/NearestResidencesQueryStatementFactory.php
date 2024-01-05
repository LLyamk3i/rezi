<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;

/**
 * @phpstan-type Statements array{having: string, select: string, where: string}
 */
final class NearestResidencesQueryStatementFactory
{
    public function __construct(
        private readonly Radius $radius,
        private readonly Location $location,
    ) {
        //
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function make(): Builder
    {
        return DB::table(table: 'residences')
            ->where(column: 'visible', operator: '=', value: true)
            ->select(columns: $this->columns())
            // ->whereRaw(sql: $this->statements['where'])
            ->having(column: 'distance', operator: '<', value: $this->radius->value)
            ->orderBy(column: 'distance');
    }

    /**
     * @return array<int,string|\Illuminate\Contracts\Database\Query\Expression>
     */
    private function columns(): array
    {
        return [
            'id', 'name', 'address',
            DB::raw('ST_X(location) AS latitude'),
            DB::raw('ST_Y(location) AS longitude'),
            DB::raw(value: sprintf(
                '(6371 * ACOS(%.16f * COS(RADIANS(ST_X(location))) 
                * COS(RADIANS(ST_Y(location)) - %.16f) + %.16f
                * SIN(RADIANS(ST_X(location))))) AS distance',
                cos(num: deg2rad(num: $this->location->latitude)),
                deg2rad(num: $this->location->longitude),
                sin(num: deg2rad(num: $this->location->latitude))
            )),
        ];
    }
}
