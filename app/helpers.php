<?php

declare(strict_types=1);

if (! \function_exists(function: 'string_value')) {
    function string_value(mixed $value): string
    {
        if (! \is_string($value)) {
            throw new \InvalidArgumentException(message: 'the value received is not a string');
        }

        return $value;
    }
}

if (! \function_exists(function: 'boolean_value')) {
    function boolean_value(mixed $value): bool
    {
        if (! \is_bool($value)) {
            throw new \InvalidArgumentException(message: 'the value received is not a boolean');
        }

        return $value;
    }
}

if (! \function_exists(function: 'integer_value')) {
    function integer_value(mixed $value): int
    {
        if (! \is_int($value)) {
            throw new \InvalidArgumentException(message: 'the value received is not a integer');
        }

        return $value;
    }
}
