<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Factories;

use Modules\Reservation\Domain\Enums\Status;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\ValueObjects\Duration;
use Modules\Reservation\Domain\Entities\Reservation;

/**
 * @phpstan-type ReservationRecord array{}
 */
final class ReservationFactory
{
    /**
     * @phpstan-param ReservationRecord $data
     *
     * @throws \Exception
     * @throws \InvalidArgumentException
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function make(array $data): Reservation
    {
        return new Reservation(
            id: new Ulid(value: $data['id']),
            stay: $this->stay(data: $data),
            owner: isset($data['user']) ? new Ulid(value: $data['owner']) : null,
            cost: isset($data['cost']) ? new Ulid(value: $data['cost']) : null,
            status: isset($data['status']) ? Status::tryFrom(value: $data['status']) : null,
            residence: isset($data['residence']) ? new Ulid(value: $data['residence']) : null,
        );
    }

    /**
     * @phpstan-param ReservationRecord $data
     *
     * @throws \Exception
     * @throws \InvalidArgumentException
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    private function stay(array $data): Duration
    {
        return new Duration(
            start: new \DateTime(datetime: $data['checkin_at']),
            end: new \DateTime(datetime: $data['checkout_at']),
        );
    }
}
