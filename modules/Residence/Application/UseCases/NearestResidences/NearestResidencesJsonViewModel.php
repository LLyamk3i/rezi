<?php

declare(strict_types=1);

namespace Modules\Residence\Application\UseCases\NearestResidences;

final class NearestResidencesJsonViewModel
{
    /**
     * @param array<int,\Modules\Residence\Domain\Entities\Residence> $data
     */
    public function __construct(
        public readonly int $status,
        public readonly bool $success,
        public readonly string $message,
        public readonly array $data,
    ) {
    }
}
