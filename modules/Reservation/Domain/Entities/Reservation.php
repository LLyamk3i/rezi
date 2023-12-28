<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Entities;

use Modules\Reservation\Domain\Enums\Status;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Price;
use Modules\Shared\Domain\ValueObjects\Duration;

/**
 * @phpstan-type ReservationFormat array{}
 */
final readonly class Reservation
{
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
    public function __serialize(): array
    {
        return [
            'id' => $this->id->value,
            'owner' => $this->owner?->value,
            'cost' => $this->cost?->value,
            'stay' => $this->stay->__serialize(),
            'status' => $this->status?->value,
            'residence' => $this->residence?->value,
        ];
    }
}
