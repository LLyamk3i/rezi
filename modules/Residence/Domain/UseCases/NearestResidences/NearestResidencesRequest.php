<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\NearestResidences;

use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;

final readonly class NearestResidencesRequest
{
    public function __construct(
        public Radius $radius,
        public Location $location,
    ) {
        //
    }
}
