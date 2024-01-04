<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\SearchResidences;

use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Shared\Domain\ValueObjects\Pagination\Page;

/**
 * @phpstan-type Search array{types:\Modules\Shared\Domain\ValueObjects\Ulid[],latest:bool,features:\Modules\Shared\Domain\ValueObjects\Ulid[],rent:array{min?:int,max?:int},stay:Duration|null,keyword:string|null}
 */
final readonly class SearchResidencesRequest
{
    /**
     * @param array<int,\Modules\Shared\Domain\ValueObjects\Ulid> $types
     * @param array<int,\Modules\Shared\Domain\ValueObjects\Ulid> $features
     *
     * @phpstan-param Search['rent']                    $rent
     */
    public function __construct(
        public Page $page,
        public array $types = [],
        public bool $latest = true,
        public array $features = [],
        public array $rent = [],
        public Duration | null $stay = null,
        public string | null $keyword = null,
    ) {
        //
    }

    /**
     * @phpstan-return Search
     */
    public function data(): array
    {
        return [
            'types' => $this->types,
            'latest' => $this->latest,
            'features' => $this->features,
            'rent' => $this->rent,
            'stay' => $this->stay,
            'keyword' => $this->keyword,
        ];
    }
}
