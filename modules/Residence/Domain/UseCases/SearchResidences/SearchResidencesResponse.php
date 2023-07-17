<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\SearchResidences;

final class SearchResidencesResponse
{
    /**
     * @param array<int,\Modules\Residence\Domain\Entities\Residence> $residences
     */
    public function __construct(
        public readonly bool $failed,
        public readonly string $message,
        public readonly array $residences,
    ) {
        //
    }
}
