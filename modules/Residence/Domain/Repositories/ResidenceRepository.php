<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Repositories;

use Modules\Shared\Domain\ValueObjects\Ulid;
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
    public function all(Page $page = new Page): PaginatedObject;

    /**
     * @throws \InvalidArgumentException
     */
    public function find(Ulid $id): null | Residence;

    /**
     * get nearest residences from database
     *
     * @return PaginatedObject<\Modules\Residence\Domain\Entities\Residence>
     *
     * @throws \InvalidArgumentException
     */
    public function nearest(Location $location, Radius $radius, Page $page = new Page): PaginatedObject;

    /**
     * @return PaginatedObject<\Modules\Residence\Domain\Entities\Residence>
     */
    public function search(string $key, Duration $stay, Page $page = new Page): PaginatedObject;
}
