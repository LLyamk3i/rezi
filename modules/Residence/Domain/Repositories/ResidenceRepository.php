<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Repositories;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Residence\Domain\Entities\Residence;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;

interface ResidenceRepository
{
    /**
     * @return array<int,Residence>
     */
    public function all(): array;

    public function find(Ulid $id): ?Residence;

    /**
     * @return array<int,Residence>
     */
    public function nearest(Location $location, Radius $radius): array;

    /**
     * @return array<int,Residence>
     */
    public function search(string $key, Duration $stay): array;
}
