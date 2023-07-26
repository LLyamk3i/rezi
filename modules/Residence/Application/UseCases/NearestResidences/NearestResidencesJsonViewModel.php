<?php

declare(strict_types=1);

namespace Modules\Residence\Application\UseCases\NearestResidences;

final readonly class NearestResidencesJsonViewModel
{
    /**
     * @param array<int,\Modules\Residence\Domain\Entities\Residence> $data
     */
    public function __construct(
        public int $status,
        public bool $success,
        public string $message,
        public array $data,
    ) {
        //
    }
}
