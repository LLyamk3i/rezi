<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Entities;

use Modules\Reservation\Domain\Enums\Status;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Shared\Domain\Concerns\Serializable;
use Modules\Shared\Domain\ValueObjects\Duration;

/**
 * @phpstan-type ReservationFormat array{id:string,owner:string|null,cost:float|null,stay:array{start:string,end:string},status:'cancelled'|'completed'|'confirmed'|'pending'|null,residence:string|null}
 */
final readonly class Reservation
{
    use Serializable;

    public function __construct(
        public Ulid $id,
        public Duration $stay,
        public Ulid | null $owner = null,
        public Price | null $cost = null,
        public Status | null $status = null,
        public Ulid | null $residence = null,
    ) {
        //
    }

    /**
     * @phpstan-return ReservationFormat
     */
    public function serialize(): array
    {
        return [
            'id' => $this->id->value,
            'owner' => $this->owner?->value,
            'cost' => $this->cost?->value,
            'stay' => $this->stay->serialize(),
            'status' => $this->status?->value,
            'residence' => $this->residence?->value,
        ];
    }
}
