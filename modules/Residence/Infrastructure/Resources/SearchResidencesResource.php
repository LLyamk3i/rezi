<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class SearchResidencesResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Modules\Residence\Domain\Entities\Residence
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array{id: string, name: string, address: string, description: string, distance: string, location: \Modules\Residence\Domain\ValueObjects\Location, rent: array{value: float, format: string, currency: string}}
     */
    public function toArray(Request $request): array
    {
        return $this->resource->__serialize();
    }
}
