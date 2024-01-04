<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Eloquent\Buckets;

use Illuminate\Support\Arr;
use Illuminate\Database\Query\Builder;
use Modules\Residence\Domain\Contracts\FilterContract;

final readonly class SearchResidenceBucket
{
    /**
     * @var array<string,class-string<FilterContract>>
     */
    private const FILTERS = [
        'stay' => \Modules\Residence\Infrastructure\Eloquent\Filters\StayFilter::class,
        'rent' => \Modules\Residence\Infrastructure\Eloquent\Filters\RentFilter::class,
        'types' => \Modules\Residence\Infrastructure\Eloquent\Filters\TypesFilter::class,
        'latest' => \Modules\Residence\Infrastructure\Eloquent\Filters\LatestFilter::class,
        'keyword' => \Modules\Residence\Infrastructure\Eloquent\Filters\KeywordFilter::class,
        'features' => \Modules\Residence\Infrastructure\Eloquent\Filters\FeaturesFilter::class,
    ];

    /**
     * @param array<string,mixed> $payloads
     */
    public function __construct(
        private Builder $query,
        private array $payloads,
    ) {
        //
    }

    public function filter(): Builder
    {
        $filtrables = Arr::only(array: $this->payloads, keys: array_keys(array: self::FILTERS));

        array_walk(array: $filtrables, callback: function (mixed $value, string $filter): void {
            $this->resolve(filter: $filter, payload: $value)->filter();
        });

        return $this->query;
    }

    private function resolve(string $filter, mixed $payload): FilterContract
    {
        return resolve(
            name: self::FILTERS[$filter],
            parameters: ['query' => $this->query, 'payload' => $payload]
        );
    }
}
