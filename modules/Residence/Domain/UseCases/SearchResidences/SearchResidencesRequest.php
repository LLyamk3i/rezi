<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\SearchResidences;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Shared\Domain\ValueObjects\Pagination\Page;

final readonly class SearchResidencesRequest
{
    /**
     * @param array{min:integer,max:integer}|null $rent
     * @param array<int,Ulid>                     $types
     * @param array<int,Ulid>                     $features
     */
    public function __construct(
        public Page $page,
        public array $types = [],
        public array $features = [],
        public array | null $rent = null,
        public Duration | null $stay = null,
        public string | null $location = null,
    ) {
        //
    }
}
