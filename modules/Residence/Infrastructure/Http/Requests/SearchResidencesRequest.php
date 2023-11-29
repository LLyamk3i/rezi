<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'location' => 'required|string',
        ];
    }

    /**
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    public function approved(): Request
    {
        return new Request(
            location: string_value(value: $this->input(key: 'location')),
            stay: $this->stay(start: 'checkin_date', end: 'checkout_date'),
            page: new Page(current: $this->integer(key: 'page', default: 1), per: $this->integer(key: 'per_page', default: 20))
        );
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
