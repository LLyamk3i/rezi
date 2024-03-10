<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Filters;

use Illuminate\Database\Query\Builder;
use Modules\Residence\Domain\Contracts\FilterContract;

final readonly class KeywordFilter implements FilterContract
{
    public function __construct(
        private Builder $query,
        private string $payload,
    ) {
        //
    }

    public function filter(): void
    {
        $attributes = ['residences.name', 'residences.address', 'residences.description'];
        $key = $this->payload;

        $this->query->where(column: static function (Builder $query) use ($key, $attributes): void {
            array_walk(array: $attributes, callback: static function (string $attribute) use ($query, $key): void {
                $query->orWhere(column: static function (Builder $query) use ($key, $attribute): void {
                    $keys = explode(separator: ' ', string: $key);
                    array_walk(array: $keys, callback: static function (string $k) use ($query, $attribute): void {
                        $query->orWhere(column: $attribute, operator: 'LIKE', value: "%{$k}%");
                    });
                });
            });
        });
    }
}
