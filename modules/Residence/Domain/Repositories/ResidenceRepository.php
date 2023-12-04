<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Repositories;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Residence\Domain\Entities\Residence;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Shared\Domain\ValueObjects\Pagination\Page;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;
use Modules\Shared\Domain\DataTransferObjects\PaginatedObject;

interface ResidenceRepository
{
    /**
     * @return PaginatedObject<\Modules\Residence\Domain\Entities\Residence>
     */
    public function all(Page $page): PaginatedObject;

    /**
     * @throws \Exception
     */
    public function find(Ulid $id): null | Residence;

    /**
     * @throws \InvalidArgumentException
     */
    public function rent(Ulid $id): null | Price;

    /**
     * get nearest residences from database
     *
     * @return array<int,\Modules\Residence\Domain\Entities\Residence>
     *
     * @throws \InvalidArgumentException
     */
    public function nearest(Location $location, Radius $radius, Page $page): array;

    /**
     * @return PaginatedObject<\Modules\Residence\Domain\Entities\Residence>
     */
    public function search(string $key, Duration | null $stay = null, Page $page): PaginatedObject;
}
