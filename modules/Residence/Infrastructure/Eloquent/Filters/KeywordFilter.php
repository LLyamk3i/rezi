<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Filters;

use Illuminate\Database\Query\Builder;
use Modules\Residence\Domain\Contracts\FilterContract;

final class KeywordFilter implements FilterContract
{
    public function __construct(
        private readonly Builder $query,
        private readonly string $payload,
    ) {
        //
    }

    public function filter(): void
    {
        $attributes = ['name', 'address', 'description'];
        $key = $this->payload;

        $this->query->where(static function (Builder $query) use ($key, $attributes): void {
            array_walk(array: $attributes, callback: static function (string $attribute) use ($query, $key): void {
                $query->orWhere(static function (Builder $query) use ($key, $attribute): void {
                    $keys = explode(' ', $key);
                    array_walk(array: $keys, callback: static function (string $k) use ($query, $attribute): void {
                        $query->orWhere(column: $attribute, operator: 'LIKE', value: "%{$k}%");
                    });
                });
            });
        });
    }
}
