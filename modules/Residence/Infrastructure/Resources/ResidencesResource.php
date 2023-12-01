<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ResidencesResource extends JsonResource
{
    /**
     * @var \Modules\Residence\Domain\Entities\Residence
     */
    public $resource;

    /**
     * @return array{id:string,name:string,address:string,description:string,distance:string,location:\Modules\Residence\Domain\ValueObjects\Location,rent:array{value:float,format:string}}
     */
    public function toArray(Request $request): array
    {
        return array_filter(
            array: [...$this->resource->__serialize(), 'poster' => $this->image()],
            callback: static fn (mixed $value) => ! \is_null(value: $value),
        );
    }

    /**
     * @return array{value:string,usage:string}|null
     */
    private function image(): array | null
    {
        if (\is_null(value: $this->resource->poster)) {
            return null;
        }

        return [
            'value' => $this->resource->poster,
            'usage' => route(name: 'image.show', parameters: ['path' => $this->resource->poster, 'w' => 500, 'h' => 500]),
        ];
    }
}
