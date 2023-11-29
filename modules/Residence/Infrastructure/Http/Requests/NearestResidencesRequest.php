<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shared\Domain\ValueObjects\Pagination\Page;
use Modules\Residence\Domain\UseCases\NearestResidences\NearestResidencesRequest as Request;

final class NearestResidencesRequest extends FormRequest
{
    /**
     * @return array{latitude:string,longitude:string,radius:string}
     */
    public function rules(): array
    {
        return [
            'page' => 'integer',
            'per_page' => 'integer',

            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'sometimes|required|integer|min:1',
        ];
    }

    /**
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function approved(): Request
    {
        return new Request(
            latitude: (float) $this->query(key: 'latitude'),
            longitude: (float) $this->query(key: 'longitude'),
            radius: (int) $this->query(key: 'radius', default: '15'),
            page: new Page(current: $this->integer(key: 'page', default: 1), per: $this->integer(key: 'per_page', default: 20))
        );
    }
}
