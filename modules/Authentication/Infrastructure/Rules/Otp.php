<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

use function Modules\Shared\Infrastructure\Helpers\string_value;

use Modules\Shared\Domain\Exceptions\InvalidValueObjectException;
use Modules\Authentication\Domain\ValueObjects\Otp as ValueObjectsOTP;

final class Otp implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        try {
            new ValueObjectsOTP(value: string_value(value: $value));
        } catch (InvalidValueObjectException) {
            $fail("Le code fourni n'est pas valide.");
        }
    }
}
