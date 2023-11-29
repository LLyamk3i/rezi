<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\SearchResidences;

use Modules\Shared\Domain\ValueObjects\Pagination\Page;

final readonly class SearchResidencesRequest
{
    public function __construct(
        public string $location,
        public \DateTime $checkin,
        public \DateTime $checkout,
        public Page $page = new Page(),
    ) {
        //
    }
}
