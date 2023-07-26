<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\SearchResidences;

final readonly class SearchResidencesResponse
{
    /**
     * @param array<int,\Modules\Residence\Domain\Entities\Residence> $residences
     */
    public function __construct(
        public bool $failed,
        public string $message,
        public array $residences,
    ) {
        //
    }
}
