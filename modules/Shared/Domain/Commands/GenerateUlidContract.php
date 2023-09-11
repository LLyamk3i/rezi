<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Commands;

use Modules\Shared\Domain\ValueObjects\Ulid;

interface GenerateUlidContract
{
    public function handle(): Ulid;
}
