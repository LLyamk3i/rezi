<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\UseCases\ShowResidence;

use Modules\Shared\Domain\ValueObjects\Ulid;

final readonly class ShowResidenceRequest
{
    public function __construct(
        public Ulid $residence,
    ) {
        //
    }
}
