<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Contracts;

interface GeneratorContract
{
    public function generate(): string;
}
