<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Shared\Infrastructure\Factories\ImageUrlFactory;

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
            array: [
                ...$this->resource->__serialize(),
                'poster' => ImageUrlFactory::make(path: $this->resource->poster),
            ],
            callback: static fn (mixed $value) => ! \is_null(value: $value),
        );
    }
}
