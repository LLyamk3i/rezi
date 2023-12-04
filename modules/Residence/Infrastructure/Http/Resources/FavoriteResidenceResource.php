<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Shared\Infrastructure\Factories\ImageUrlFactory;

final class FavoriteResidenceResource extends JsonResource
{
    /**
     * @var \Modules\Residence\Infrastructure\Models\Residence
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...$this->resource->toArray(),
            'poster' => ImageUrlFactory::make(path: $this->resource->poster?->getAttribute(key: 'path')),
        ];
    }
}
