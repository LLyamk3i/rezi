<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Exceptions;

final class InvalidValueObjectException extends \InvalidArgumentException
{
    public function __construct(string | float | int $value, string $object)
    {
        parent::__construct(message: "{$value} is not a valid value for {$object}");
    }
}
