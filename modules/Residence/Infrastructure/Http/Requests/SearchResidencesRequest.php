<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Requests;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Shared\Infrastructure\Rules\Keys;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Shared\Domain\ValueObjects\Pagination\Page;
use Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesRequest as Request;

use function Modules\Shared\Infrastructure\Helpers\string_value;

/**
 * @phpstan-import-type Search from \Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesRequest
 */
final class SearchResidencesRequest extends FormRequest
{
    /**
     * @return array{page:string,per_page:string,checkin_date:string,checkout_date:string,keyword:string,type_ids:\Modules\Shared\Infrastructure\Rules\Keys[],feature_ids:\Modules\Shared\Infrastructure\Rules\Keys[],rent_min:string,rent_max:string,latest:string}
     */
    public function rules(): array
    {
        return [
            'page' => 'integer',
            'keyword' => 'string',
            'latest' => 'boolean',
            'per_page' => 'integer',
            'checkin_date' => 'date',
            'checkout_date' => 'date',
            'rent_min' => 'integer|min:0',
            'rent_max' => 'integer|min:0',
            'feature_ids' => [new Keys(table: 'features')],
            'type_ids' => [new Keys(table: 'residences', column: 'type_id')],
        ];
    }

    /**
     * @throws \Exception
     * @throws \InvalidArgumentException
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function approved(): Request
    {
        return new Request(
            rent: $this->rent(),
            types: $this->ids(key: 'type_ids'),
            features: $this->ids(key: 'feature_ids'),
            latest: $this->boolean(key: 'latest', default: true),
            stay: $this->stay(start: 'checkin_date', end: 'checkout_date'),
            keyword: $this->has(key: 'keyword') ? (string) $this->string(key: 'keyword') : null,
            page: new Page(
                current: $this->integer(key: 'page', default: 1),
                per: $this->integer(key: 'per_page', default: 20)
            )
        );
    }

    private function ids(string $key): array
    {
        return array_map(
            array: Arr::wrap($this->input(key: $key, default: [])),
            callback: static fn (string $id): Ulid => new Ulid(value: $id)
        );
    }

    /**
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     *
     * @phpstan-return Search['rent']
     */
    private function rent(): array
    {
        return collect($this->only(keys: ['rent_min', 'rent_max']))
            ->flatMap(callback: static fn (int $value, string $key): array => [ltrim(string: $key, characters: 'rent_') => new Price(value: $value)])
            ->toArray();
    }

    /**
     * @throws \Exception
     */
    private function stay(string $start, string $end): Duration | null
    {
        if (! $this->has(key: $start)) {
            return null;
        }

        if (! $this->has(key: $end)) {
            return null;
        }

        return new Duration(
            end: new \DateTime(datetime: string_value(value: $this->input(key: $end))),
            start: new \DateTime(datetime: string_value(value: $this->input(key: $start))),
        );
    }
}
