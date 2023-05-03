<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Contracts;

interface NearestResidencesStatementContract
{
    public function statement(): string;
}
