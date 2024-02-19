<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Shared\Application\Repositories\Repository;
use Modules\Shared\Domain\ValueObjects\Pagination\Page;
use Modules\Residence\Domain\Hydrators\ResidenceHydrator;
use Modules\Residence\Domain\Entities\Residence as Entity;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;
use Modules\Residence\Domain\Repositories\ResidenceRepository;
use Modules\Residence\Infrastructure\Factories\ColumnsFactory;
use Modules\Shared\Domain\DataTransferObjects\PaginatedObject;
use Modules\Residence\Infrastructure\Queries\ResidenceDetailsQuery;
use Modules\Residence\Infrastructure\Factories\ResidenceQueryFactory;
use Modules\Residence\Infrastructure\Eloquent\Buckets\SearchResidenceBucket;
use Modules\Residence\Infrastructure\Factories\NearestResidencesQueryStatementFactory;

use function Modules\Shared\Infrastructure\Helpers\array_filter_filled;

/**
 * @phpstan-import-type ResidenceRecord from \Modules\Residence\Domain\Factories\ResidenceFactory
 * @phpstan-import-type Search from \Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesRequest
 */
final readonly class EloquentResidenceRepository implements ResidenceRepository
{
    public function __construct(
        private Repository $parent,
        private ColumnsFactory $columns,
        private ResidenceHydrator $hydrator,
        private ResidenceQueryFactory $query,
        private ResidenceDetailsQuery $details,
    ) {
    }

    /**
     * @return PaginatedObject<\Modules\Residence\Domain\Entities\Residence>
     */
    public function all(Page $page): PaginatedObject
    {
        return $this->search(page: $page, data: ['latest' => true]);
    }

    public function find(Ulid $id): null | Entity
    {
        return $this->details->run(id: $id);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function rent(Ulid $id): null | Price
    {
        $rent = DB::table(table: 'residences')
            ->where(column: 'id', operator: '=', value: $id->value)
            ->where(column: 'visible', operator: '=', value: 1)
            ->value(column: 'rent');

        if (\is_int(value: $rent)) {
            return new Price(value: $rent);
        }

        return null;
    }

    /**
     * get nearest residences from database
     *
     * @return array<int,Entity>
     *
     * @throws \InvalidArgumentException
     */
    public function nearest(Location $location, Radius $radius): array
    {
        $factory = new NearestResidencesQueryStatementFactory(radius: $radius, location: $location);

        /** @phpstan-var array<int,ResidenceRecord> $residences */
        $residences = $factory->make()->get()->toArray();

        return $this->hydrator->hydrate(data: $residences);
    }

    /**
     * @phpstan-param Search $data
     *
     * @return PaginatedObject<\Modules\Residence\Domain\Entities\Residence>
     */
    public function search(Page $page, array $data): PaginatedObject
    {
        $bucket = new SearchResidenceBucket(
            query: $this->query->make(),
            payloads: array_filter_filled(array: $data),
        );

        return $this->parent->paginate(
            page: $page,
            query: $bucket->filter(),
            hydrator: $this->hydrator,
            columns: $this->columns->make(),
        );
    }
}
