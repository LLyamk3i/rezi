<?php

declare(strict_types=1);

namespace Modules\Reservation\Domain\Hydrators;

use Modules\Reservation\Domain\Entities\Reservation;
use Modules\Shared\Domain\Contracts\HydratorContract;
use Modules\Reservation\Domain\Factories\ReservationFactory;

/**
 * @phpstan-import-type ReservationRecord from \Modules\Reservation\Domain\Factories\ReservationFactory
 *
 * @implements HydratorContract<ReservationRecord,Reservation>
 */
final readonly class ReservationHydrator implements HydratorContract
{
    public function __construct(
        private ReservationFactory $factory,
    ) {
        //
    }

    /**
     * @phpstan-param array<int,ReservationRecord> $data
     *
     * @return array<int,Reservation>
     */
    public function hydrate(array $data): array
    {
        return array_map(
            callback: fn (array $row): Reservation => $this->factory->make(data: $row),
            array: $data,
        );
    }
}
