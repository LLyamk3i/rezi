<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Residence\Domain\ValueObjects\Location;
use Modules\Residence\Domain\ValueObjects\Distance as Radius;
use Modules\Residence\Domain\UseCases\NearestResidences\NearestResidencesRequest as Request;

final class NearestResidencesRequest extends FormRequest
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

    /**
     * @throws \InvalidArgumentException
     */
    public function approved(): Request
    {
        return new Request(
            radius: new Radius(value: $this->integer(key: 'radius', default: 15)),
            location: new Location(
                latitude: $this->float(key: 'latitude'),
                longitude: $this->float(key: 'longitude')
            ),
        );
    }
}
