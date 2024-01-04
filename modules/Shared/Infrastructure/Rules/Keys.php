<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Rules;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

final readonly class Keys implements ValidationRule
{
    public function __construct(
        private string $table,
        private string $column = 'id',
    ) {
        //
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $keys = Arr::wrap(value: $value);

        if (! DB::table(table: $this->table)->whereIn(column: $this->column, values: $keys)->exists()) {
            $fail('shared::messages.validation.ids')->translate(replace: ['attribute' => $attribute, 'table' => $this->table]);
        }
    }
}
