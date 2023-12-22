<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Shared\Domain\ValueObjects\Pagination\Page;
use Modules\Residence\Domain\UseCases\SearchResidences\SearchResidencesRequest as Request;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class SearchResidencesRequest extends FormRequest
{
    /**
     * @return array{checkin_date:string,checkout_date:string,location:string}
     */
    public function rules(): array
    {
        return [
            'page' => 'integer',
            'per_page' => 'integer',
            'checkin_date' => 'date',
            'checkout_date' => 'date',
            'location' => 'string',
            'type_id' => 'string|exists:types,id',
            'feature_id' => 'string|exists:features,id',
            'rent_min' => 'integer|min:0',
            'rent_max' => 'integer|min:0',
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
            rent: $this->rent() ?? [],
            stay: $this->stay(start: 'checkin_date', end: 'checkout_date'),
            type: $this->has(key: 'type') ? new Ulid(value: (string) $this->string(key: 'type')) : null,
            feature: $this->has(key: 'feature') ? new Ulid(value: (string) $this->string(key: 'feature')) : null,
            location: $this->has(key: 'location') ? (string) $this->string(key: 'location') : null,
            page: new Page(
                current: $this->integer(key: 'page', default: 1),
                per: $this->integer(key: 'per_page', default: 20)
            )
        );
    }

    /**
     * @return array{min:int,max:int}|null
     *
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    private function rent(): array | null
    {
        if (! $this->has(key: 'rent_min') || ! $this->has(key: 'rent_max')) {
            return null;
        }

        return [
            'min' => new Price(value: $this->integer(key: 'rent_min')),
            'max' => new Price(value: $this->integer(key: 'rent_max')),
        ];
    }

    /**
     * @throws \Exception
     */
    private function stay(string $start, string $end): Duration | null
    {
        if (! $this->has(key: $start) || ! $this->has(key: $end)) {
            return null;
        }

        return new Duration(
            start: $this->datetime(key: $start),
            end: $this->datetime(key: $end),
        );
    }

    /**
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    private function datetime(string $key): \DateTime
    {
        return new \DateTime(datetime: string_value(value: $this->input(key: $key)));
    }
}
