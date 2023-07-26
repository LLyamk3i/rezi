<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\SearchResidences;

final readonly class SearchResidencesRequest
{
    public function __construct(
        public \DateTime $checkin,
        public \DateTime $checkout,
        public string $location,
    ) {
        //
    }
}
