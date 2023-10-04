<?php

declare(strict_types=1);

namespace Modules\Residence\Application\UseCases\SearchResidences;

final readonly class SearchResidencesJsonViewModel
{
    /**
     * @param array<int,\Modules\Residence\Domain\Entities\Residence> $data
     */
    public function __construct(
        public int $status,
        public bool $success,
        public string $message,
        public int $total,
        public array $data,
    ) {
        //
    }
}
