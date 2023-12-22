<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Shared\Infrastructure\Factories\ImageUrlFactory;
use Modules\Reservation\Infrastructure\Resources\ReservationResource;

use function Modules\Shared\Infrastructure\Helpers\array_filter_filled;

final class ResidenceResource extends JsonResource
{
    /**
     * @var \Modules\Residence\Domain\Entities\Residence
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
            'poster' => ImageUrlFactory::make(path: $this->resource->poster),
            'ratings' => RatingResource::collection(resource: $this->resource->ratings ?? []),
            'features' => FeatureResource::collection(resource: $this->resource->features ?? []),
            'reservations' => ReservationResource::collection(resource: $this->resource->reservations ?? []),
        ]);
    }
}
