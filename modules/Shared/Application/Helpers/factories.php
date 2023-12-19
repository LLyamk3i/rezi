<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Helpers;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Symfony\Component\Uid\Ulid as SymfonyUlid;

/**
 * @throws \InvalidArgumentException
 * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
 */
function make_ulid_value(mixed $value): Ulid
{
    return new Ulid(value: string_value(value: $value));
}

function ulid(): Ulid
{
    return make_ulid_value(value: SymfonyUlid::generate());
}
