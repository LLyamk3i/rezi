<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Contracts;

interface FilterContract
{
    public function filter(): void;
}
