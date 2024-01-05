<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Rules;

use Closure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\ValidationRule;

use function Modules\Shared\Infrastructure\Helpers\boolean_value;

final class Email implements ValidationRule
{
    /**
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = ['email' => $value];

        if (boolean_value(value: config(key: 'app.debug'))) {
            Validator::validate(data: $data, rules: ['email' => 'email:strict']);

            return;
        }

        Validator::validate(data: $data, rules: ['email' => 'email:spoof,dns']);
    }
}
