<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Resources;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Shared\Domain\Supports\StoreContract;
use Modules\Shared\Infrastructure\Factories\ImageUrlFactory;

use Modules\Reservation\Infrastructure\Resources\ReservationResource;

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
        /** @var StoreContract $store */
        $store = app(abstract: StoreContract::class);
        /** @var array<int,string> $keys */
        $keys = $store->get(key: 'inventory');

        return Arr::only(keys: $keys, array: [
            ...$this->resource->serialize(),
            'owner' => new OwnerResource(resource: $this->resource->owner),
            'poster' => ImageUrlFactory::make(path: $this->resource->poster),
            'ratings' => RatingResource::collection(resource: $this->resource->ratings ?? []),
            'features' => FeatureResource::collection(resource: $this->resource->features ?? []),
            'reservations' => ReservationResource::collection(resource: $this->resource->reservations ?? []),
        ]);
    }
}
