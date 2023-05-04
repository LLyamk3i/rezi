<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Repositories;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Residence\Domain\Entities\Residence;
use Modules\Residence\Domain\ValueObjects\Radius;
use Modules\Residence\Domain\ValueObjects\Location;

interface ResidenceRepository
{
    /**
     * @return array<int,Residence>
     */
    public function all(): array;

    public function save(Residence $residence): void;

    public function find(Ulid $id): Residence | null;

    /**
     * @return array<int,Residence>
     */
    public function nearest(Location $location, Radius $radius): array;
}
