<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\NearestResidences;

final readonly class NearestResidencesRequest
{
    public function __construct(
        public int $radius,
        public float $latitude,
        public float $longitude,
    ) {
        //
    }
}
