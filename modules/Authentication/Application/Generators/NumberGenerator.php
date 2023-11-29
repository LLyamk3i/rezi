<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\Generators;

use Modules\Shared\Domain\Contracts\GeneratorContract;
use Modules\Authentication\Domain\Exceptions\OneTimePasswordGenerationException;

final class NumberGenerator implements GeneratorContract
{
    /**
     * @throws \Modules\Authentication\Domain\Exceptions\OneTimePasswordGenerationException
     */
    public function generate(): string
    {
        try {
            $number = random_int(min: 000_000, max: 999_999);
        } catch (\Throwable) {
            throw new OneTimePasswordGenerationException(message: 'Failed to generate a random integer');
        }

        return str_pad(
            string: \strval(value: $number),
            length: 6,
            pad_string: '0',
            pad_type: \STR_PAD_LEFT,
        );
    }
}
