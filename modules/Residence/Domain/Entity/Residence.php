<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Entity;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Residence\Domain\ValueObjects\Distance;
use Modules\Residence\Domain\ValueObjects\Location;

final class Residence
{
    public function __construct(
        public readonly Ulid $id,
        public readonly string $name,
        public readonly string $address,
        public readonly Distance $distance,
        public readonly Location $location,
        // public readonly Owner $owner,
    ) {
    }
}
