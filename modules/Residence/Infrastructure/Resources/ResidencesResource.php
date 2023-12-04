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
     * @return array<string,array<string,float|string>|\Modules\Residence\Domain\ValueObjects\Location|string>
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
