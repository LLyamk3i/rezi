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
     * @return array{id:string,name:string,icon:string|null}
     */
    public function toArray(Request $request): array
    {
        return [
            ...$this->resource->__serialize(),
            'icon' => $this->icon(value: $this->resource->icon),
        ];
    }

    private function icon(string | null $value): null | string
    {
        if (\is_string(value: $value)) {
            return route(name: 'image.show', parameters: ['path' => $value]);
        }

        return null;
    }
}
