<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class RatingResource extends JsonResource
{
    /**
     * @var \Modules\Residence\Domain\Entities\Rating
     */
    public $resource;

    /**
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...$this->resource->__serialize(),
            'owner' => new OwnerResource(resource: $this->resource->owner),
        ];
    }
}
