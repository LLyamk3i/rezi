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
     */
    public function __construct(
        public Page $page,
        public array | null $rent = null,
        public Ulid | null $type = null,
        public Ulid | null $feature = null,
        public Duration | null $stay = null,
        public string | null $location = null,
    ) {
        //
    }
}
