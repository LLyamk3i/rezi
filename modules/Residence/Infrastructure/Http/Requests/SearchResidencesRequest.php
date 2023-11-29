<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date',
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
            checkin: new \DateTime(datetime: string_value(value: $this->input(key: 'checkin_date'))),
            checkout: new \DateTime(datetime: string_value(value: $this->input(key: 'checkout_date'))),
            location: string_value(value: $this->input(key: 'location')),
        );
    }
}
