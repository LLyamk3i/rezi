<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class FeatureResource extends JsonResource
{
    /**
     * @var \Modules\Residence\Domain\Entities\Feature
     */
    public $resource;

    /**
     * @return array<string,string>
     */
    public function toArray(Request $request): array
    {
        return [
            ...$this->resource->__serialize(),
            'icon' => route(name: 'image.show', parameters: ['path' => $this->resource->icon]),
        ];
    }
}
