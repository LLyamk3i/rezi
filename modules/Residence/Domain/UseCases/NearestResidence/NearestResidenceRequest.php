<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\NearestResidence;

final class NearestResidenceRequest
{
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly int $radius = 15,
    ) {
    }
}
