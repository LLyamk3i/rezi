<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Query\Builder;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;

/**
 * @phpstan-type Statements array{having: string, select: string, where: string}
 */
final class NearestResidencesQueryStatementFactory
{
    /**
     * @phpstan-var Statements
     */
    private const RAW_STATEMENTS = [
        'having' => 'distance < :rad',
        'select' => '(6371 * ACOS(COS(RADIANS(:lat)) * COS(RADIANS(ST_Y(location))) * COS(RADIANS(ST_X(location)) - RADIANS(:lng))+ SIN(RADIANS(:lat)) * SIN(RADIANS(ST_Y(location))))) AS distance',
        'where' => 'MBRContains(LineString(Point(:lng + :rad / (111.320 * COS(RADIANS(:lat))), :lat + :rad / 111.133),Point(:lng - :rad / (111.320 * COS(RADIANS(:lat))), :lat - :rad / 111.133)), location)',
    ];

    /**
     * @phpstan-var Statements
     */
    private readonly array $statements;

    /**
     * @var array<int,\Illuminate\Contracts\Database\Query\Expression|string>
     */
    private readonly array $columns;

    private readonly ResidenceQueryFactory $query;

    /**
     * @param array<int,\Illuminate\Contracts\Database\Query\Expression|string> $columns
     */
    public function __construct(Radius $radius, Location $location, array $columns, ResidenceQueryFactory $query)
    {
        $this->query = $query;
        $this->columns = $columns;
        $this->statements = self::replace(radius: $radius, location: $location);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function make(): Builder
    {
        return $this->query->make()
            ->select(columns: [DB::raw(value: $this->statements['select']), ...$this->columns])
            ->whereRaw(sql: $this->statements['where'])
            ->havingRaw(sql: $this->statements['having'])
            ->orderBy(column: 'distance');
    }

    /**
     * @phpstan-return Statements
     */
    private static function replace(Radius $radius, Location $location): array
    {
        return array_map(array: self::RAW_STATEMENTS, callback: static fn (string $statement) => str_replace(
            subject: $statement,
            search: [':lat', ':lng', ':rad'],
            replace: [$location->latitude, $location->longitude, $radius->value],
        ));
    }
}
