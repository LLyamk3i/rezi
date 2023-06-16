<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\SearchResidences;

final class SearchResidencesRequest
{
    public function __construct(
        public readonly \DateTime $checkin,
        public readonly \DateTime $checkout,
        public readonly string $location,
    ) {
        //
    }
}
