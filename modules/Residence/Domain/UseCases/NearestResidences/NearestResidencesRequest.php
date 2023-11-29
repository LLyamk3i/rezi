<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\NearestResidences;

use Modules\Shared\Domain\ValueObjects\Pagination\Page;

final readonly class NearestResidencesRequest
{
    public function __construct(
        public Page $page,
        public int $radius,
        public float $latitude,
        public float $longitude,
    ) {
        //
    }
}
