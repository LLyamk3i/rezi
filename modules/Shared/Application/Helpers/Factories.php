<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Helpers;

use Modules\Shared\Domain\ValueObjects\Ulid;

function make_ulid_value(mixed $value): Ulid
{
    return new Ulid(value: string_value(value: $value));
}
