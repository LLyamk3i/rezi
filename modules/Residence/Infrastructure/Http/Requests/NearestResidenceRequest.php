<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Residence\Domain\UseCases\NearestResidence\NearestResidenceRequest as Request;

class NearestResidenceRequest extends FormRequest
{
    /**
     * @return array{latitude:string,longitude:string,radius:string}
     */
    public function rules(): array
    {
        return [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'sometimes|required|integer|min:1',
        ];
    }

    public function approved(): Request
    {
        return new Request(
            latitude: (float) $this->query(key: 'latitude'),
            longitude: (float) $this->query(key: 'longitude'),
            radius: (int) $this->query(key: 'radius', default: '15'),
        );
    }
}
