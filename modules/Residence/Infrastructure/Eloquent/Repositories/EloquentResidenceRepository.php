<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Residence\Domain\ValueObjects\Radius;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\Factories\ResidenceFactory;
use Modules\Residence\Domain\Hydrators\ResidenceHydrator;
use Modules\Residence\Domain\Entities\Residence as Entity;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Residence\Infrastructure\Eloquent\Buckets\SearchResidenceBucket;

/**
 * @phpstan-import-type ResidenceRecord from \Modules\Residence\Domain\Factories\ResidenceFactory
 */
final class EloquentResidenceRepository implements ResidenceRepository
{
    public function __construct(
        private readonly ResidenceFactory $factory,
        private readonly ResidenceHydrator $hydrator,
    ) {
    }

    /**
     * @return array<int,Entity>
     */
    public function all(): array
    {
        /** @phpstan-var array<int,ResidenceRecord> $residences */
        $residences = $this->builder()->get(columns: $this->attributes())->toArray();

        return $this->hydrator->hydrate(data: $residences);
    }

    public function find(Ulid $id): Entity | null
    {
        /** @phpstan-var ResidenceRecord|null $residence */
        $residence = $this->builder()->where('id', $id->value)
            ->limit(1)
            ->get(columns: $this->attributes())
            ->first();

        return \is_array(value: $residence)
            ? $this->factory->make(data: $residence)
            : null;
    }

    /**
     * get nearest residences from database
     *
     * @return array<int,Entity>
     */
    public function nearest(Location $location, Radius $radius): array
    {
        $statement = 'SELECT id, name, address,
            ST_X(location) AS latitude,
            ST_Y(location) AS longitude,
            (6371 * ACOS(COS(RADIANS(:lat))
            * COS(RADIANS(ST_Y(location)))
            * COS(RADIANS(ST_X(location)) 
            - RADIANS(:lng))
            + SIN(RADIANS(:lat))
            * SIN(RADIANS(ST_Y(location))))
            ) AS distance
        FROM residences
        WHERE MBRContains(
            LineString(
                Point(:lng + :rad / (111.320 * COS(RADIANS(:lat))),:lat + :rad / 111.133),
                Point (:lng - :rad / (111.320 * COS(RADIANS(:lat))), :lat - :rad / 111.133)
            ),location)
        HAVING distance < :rad ORDER By distance;';

        /** @phpstan-var array<int,ResidenceRecord> $residences */
        $residences = DB::select(query: str_replace(
            search: [':lat', ':lng', ':rad'],
            replace: [$location->latitude, $location->longitude, $radius->value],
            subject: $statement
        ));

        return $this->hydrator->hydrate(data: $residences);
    }

    public function save(Entity $residence): void
    {
        //
    }

    /**
     * @return array<int,Entity>
     */
    public function search(?string $key = null, ?Duration $stay = null): array
    {
        /** @phpstan-var array<int,ResidenceRecord> $residences */
        $residences = (new SearchResidenceBucket(query: $this->builder(), payloads: get_defined_vars()))
            ->filter()
            ->get(columns: $this->attributes())
            ->toArray();

        return $this->hydrator->hydrate(data: $residences);
    }

    /**
     * @return array<int,string|\Illuminate\Contracts\Database\Query\Expression>
     */
    private function attributes(): array
    {
        return [
            'id',
            'name',
            'address',
            'rent',
            'description',
            DB::raw('ST_X(location) AS latitude'),
            DB::raw('ST_Y(location) AS longitude'),
        ];
    }

    private function builder(): Builder
    {
        return DB::table(table: 'residences');
    }
}
