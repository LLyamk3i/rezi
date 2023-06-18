<?php

declare(strict_types=1);

namespace Modules\Residence\Application\UseCases\SearchResidences;

class SearchResidencesJsonViewModel
{
    /**
     * @param array<int,\Modules\Residence\Domain\Entities\Residence> $data
     */
    public function __construct(
        public readonly int $status,
        public readonly bool $success,
        public readonly string $message,
        public readonly int $total,
        public readonly array $data,
    ) {
        //
    }
}
