<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Buckets;

use Illuminate\Support\Arr;
use Illuminate\Database\Query\Builder;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Residence\Domain\Contracts\FilterContract;

final class SearchResidenceBucket
{
    /**
     * @var array<string,class-string<FilterContract>>
     */
    private array $filters = [
        'key' => \Modules\Residence\Infrastructure\Eloquent\Filters\KeywordFilter::class,
        'stay' => \Modules\Residence\Infrastructure\Eloquent\Filters\StayDurationFilter::class,
    ];

    /**
     * @param array<string,string|Duration> $payloads
     */
    public function __construct(
        private readonly Builder $query,
        private readonly array $payloads,
    ) {
        //
    }

    public function filter(): Builder
    {
        $filters = $this->filters();

        array_walk(array: $filters, callback: function (string | Duration $value, string $filter): void {
            $this->resolve(filter: $filter, payload: $value)->filter();
        });

        return $this->query;
    }

    /**
     * @return array{key?:string,stay?:\Modules\Shared\Domain\ValueObjects\Duration}
     */
    private function filters(): array
    {
        return array_filter(array: Arr::only(
            array: $this->payloads,
            keys: array_keys($this->filters)
        ));
    }

    private function resolve(string $filter, string | Duration $payload): FilterContract
    {
        return new $this->filters[$filter](query: $this->query, payload: $payload);
    }
}
