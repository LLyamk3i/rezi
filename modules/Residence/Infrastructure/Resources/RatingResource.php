<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function Modules\Shared\Infrastructure\Helpers\array_filter_filled;

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
        return array_filter_filled(array: [
            ...$this->resource->__serialize(),
            'owner' => new OwnerResource(resource: $this->resource->owner),
        ]);
    }
}
