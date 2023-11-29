<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Helpers;

/**
 * @throws \InvalidArgumentException
 */
function string_value(mixed $value): string
{
    if (! \is_string(value: $value)) {
        throw new \InvalidArgumentException(message: 'the value received is not a string');
    }

    return $value;
}

/**
 * @throws \InvalidArgumentException
 */
function boolean_value(mixed $value): bool
{
    if (! \is_bool(value: $value)) {
        throw new \InvalidArgumentException(message: 'the value received is not a boolean');
    }

    return $value;
}

/**
 * @throws \InvalidArgumentException
 */
function integer_value(mixed $value): int
{
    if (! \is_int(value: $value)) {
        throw new \InvalidArgumentException(message: 'the value received is not a integer');
    }

    return $value;
}
