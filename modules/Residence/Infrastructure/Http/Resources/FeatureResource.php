<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Shared\Infrastructure\Factories\ImageUrlFactory;

final class FeatureResource extends JsonResource
{
    /**
     * @var \Modules\Residence\Infrastructure\Models\Feature
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
            'icon' => ImageUrlFactory::make(path: $this->resource->icon?->getAttribute(key: 'path')),
        ];
    }
}
