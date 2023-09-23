<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Shared\Application\Repositories\Repository;
use Modules\Residence\Domain\Factories\ResidenceFactory;
use Modules\Residence\Domain\Hydrators\ResidenceHydrator;
use Modules\Residence\Domain\Entities\Residence as Entity;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Residence\Infrastructure\Eloquent\Buckets\SearchResidenceBucket;

/**
 * @phpstan-import-type ResidenceRecord from \Modules\Residence\Domain\Factories\ResidenceFactory
 */
final readonly class EloquentResidenceRepository implements ResidenceRepository
{
    public function __construct(
        private ResidenceFactory $factory,
        private Repository $parent,
        private ResidenceHydrator $hydrator,
    ) {
    }

    /**
     * @return array<int,Entity>
     */
    public function all(): array
    {
        /** @phpstan-var array<int,ResidenceRecord> $residences */
        $residences = DB::table(table: 'residences')->get(columns: $this->attributes())->toArray();

        return $this->hydrator->hydrate(data: $residences);
    }

    public function find(Ulid $id): ?Entity
    {
        /** @phpstan-var ResidenceRecord|null $result */
        $result = $this->parent->find(
            query: DB::table(table: 'residences')->where('id', $id->value),
            columns: $this->attributes()
        );

        return \is_array(value: $result)
            ? $this->factory->make(data: $result)
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

    /**
     * @return array<int,Entity>
     */
    public function search(?string $key = null, ?Duration $stay = null): array
    {
        $bucket = new SearchResidenceBucket(
            query: DB::table(table: 'residences'),
            payloads: get_defined_vars()
        );
        /** @phpstan-var array<int,ResidenceRecord> $residences */
        $residences = $bucket->filter()->get(columns: $this->attributes())->toArray();

        return $this->hydrator->hydrate(data: $residences);
    }

    /**
     * @return array<int,string|\Illuminate\Contracts\Database\Query\Expression>
     */
    private function attributes(): array
    {
        return [
            'id', 'name', 'address', 'rent', 'description',
            DB::raw('ST_X(location) AS latitude'),
            DB::raw('ST_Y(location) AS longitude'),
        ];
    }
}
