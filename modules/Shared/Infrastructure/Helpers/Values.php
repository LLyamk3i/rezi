<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Helpers;

function string_value(mixed $value): string
{
    if (! \is_string($value)) {
        throw new \InvalidArgumentException(message: 'the value received is not a string');
    }

    return $value;
}

function boolean_value(mixed $value): bool
{
    if (! \is_bool($value)) {
        throw new \InvalidArgumentException(message: 'the value received is not a boolean');
    }

    return $value;
}

function integer_value(mixed $value): int
{
    if (! \is_int($value)) {
        throw new \InvalidArgumentException(message: 'the value received is not a integer');
    }

    return $value;
}
