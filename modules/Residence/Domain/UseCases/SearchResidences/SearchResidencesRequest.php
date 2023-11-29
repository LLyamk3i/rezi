<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\SearchResidences;

use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Shared\Domain\ValueObjects\Pagination\Page;

final readonly class SearchResidencesRequest
{
    public function __construct(
        public string $location,
        public Page $page,
        public Duration | null $stay = null,
    ) {
        //
    }
}
