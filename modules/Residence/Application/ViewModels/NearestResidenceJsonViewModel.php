<?php

declare(strict_types=1);

namespace Modules\Residence\Application\ViewModels;

class NearestResidenceJsonViewModel
{
    /**
     * @param array<int,\Modules\Residence\Domain\Entity\Residence> $data
     */
    public function __construct(
        public readonly int $status,
        public readonly bool $success,
        public readonly string $message,
        public readonly array $data,
    ) {
    }
}
