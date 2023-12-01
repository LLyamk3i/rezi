<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Shared\Application\Repositories\Repository;
use Modules\Shared\Domain\ValueObjects\Pagination\Page;
use Modules\Residence\Domain\Hydrators\ResidenceHydrator;
use Modules\Residence\Domain\Entities\Residence as Entity;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Residence\Infrastructure\Factories\ColumnsFactory;
use Modules\Shared\Domain\DataTransferObjects\PaginatedObject;
use Modules\Residence\Infrastructure\Factories\ResidenceQueryFactory;
use Modules\Residence\Infrastructure\Eloquent\Buckets\SearchResidenceBucket;
use Modules\Residence\Infrastructure\Factories\NearestResidencesQueryStatementFactory;

/**
 * @phpstan-import-type ResidenceRecord from \Modules\Residence\Domain\Factories\ResidenceFactory
 */
final readonly class EloquentResidenceRepository implements ResidenceRepository
{
    public function __construct(
        private Repository $parent,
        private ColumnsFactory $columns,
        private ResidenceHydrator $hydrator,
        private ResidenceQueryFactory $query,
    ) {
    }

    /**
     * @return PaginatedObject<\Modules\Residence\Domain\Entities\Residence>
     */
    public function all(Page $page): PaginatedObject
    {
        return $this->parent->paginate(
            page: $page,
            hydrator: $this->hydrator,
            query: $this->query->make(),
            columns: $this->columns->make(),
        );
    }

    /**
     * @throws \Exception
     */
    public function find(Ulid $id): null | Entity
    {
        throw new \Exception(message: 'Unimplemented method', code: 1);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function rent(Ulid $id): null | Price
    {
        $rent = DB::table(table: 'residences')->where('id', $id->value)->value(column: 'rent');

        if (\is_int(value: $rent)) {
            return new Price(value: $rent);
        }

        return null;
    }

    /**
     * get nearest residences from database
     *
     * @return PaginatedObject<\Modules\Residence\Domain\Entities\Residence>
     *
     * @throws \InvalidArgumentException
     */
    public function nearest(Location $location, Radius $radius, Page $page): PaginatedObject
    {
        $factory = new NearestResidencesQueryStatementFactory(
            radius: $radius,
            location: $location,
            query: $this->query,
            columns: $this->columns->make(),
        );

        return $this->parent->paginate(
            page: $page,
            query: $factory->make(),
            hydrator: $this->hydrator,
        );
    }

    /**
     * @return PaginatedObject<\Modules\Residence\Domain\Entities\Residence>
     */
    public function search(string $key, null | Duration $stay = null, Page $page): PaginatedObject
    {
        $bucket = new SearchResidenceBucket(
            query: $this->query->make(),
            payloads: array_filter(array: ['key' => $key, 'stay' => $stay]),
        );

        return $this->parent->paginate(
            page: $page,
            query: $bucket->filter(),
            hydrator: $this->hydrator,
            columns: $this->columns->make(),
        );
    }
}
