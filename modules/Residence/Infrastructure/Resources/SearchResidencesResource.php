<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResidencesResource extends JsonResource
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
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->resource->__serialize();
    }
}
