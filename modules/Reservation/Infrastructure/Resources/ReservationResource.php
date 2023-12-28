<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ReservationResource extends JsonResource
{
    /**
     * @var \Modules\Reservation\Domain\Entities\Reservation
     */
    public $resource;

    /**
     * @return array<string,string>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id->value,
            ...$this->resource->stay->__serialize(),
        ];
    }
}
