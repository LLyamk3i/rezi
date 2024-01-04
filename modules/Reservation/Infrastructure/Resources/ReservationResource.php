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
     * @return array{id: string, start: string, end: string}
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id->value,
            ...$this->resource->stay->__serialize(),
        ];
    }
}
