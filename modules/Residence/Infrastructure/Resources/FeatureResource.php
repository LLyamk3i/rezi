<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function Modules\Shared\Infrastructure\Helpers\array_filter_filled;

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
        return array_filter_filled(array: [
            ...$this->resource->__serialize(),
            'icon' => route(name: 'image.show', parameters: ['path' => $this->resource->icon]),
        ]);
    }
}
