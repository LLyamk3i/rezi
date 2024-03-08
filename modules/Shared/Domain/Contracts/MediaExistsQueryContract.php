<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Contracts;

interface MediaExistsQueryContract
{
    public function execute(): bool;
}
