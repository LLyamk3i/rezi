<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Hydrators;

use Modules\Residence\Domain\Entities\Residence;
use Modules\Shared\Domain\Contracts\HydratorContract;
use Modules\Residence\Domain\Factories\ResidenceFactory;

/**
 * @phpstan-import-type ResidenceRecord from \Modules\Residence\Domain\Factories\ResidenceFactory
 *
 * @implements HydratorContract<ResidenceRecord,Residence>
 */
final readonly class ResidenceHydrator implements HydratorContract
{
    public function __construct(
        private ResidenceFactory $factory,
    ) {
        //
    }

    /**
     * @phpstan-param array<int,ResidenceRecord> $data
     *
     * @return array<int,Residence>
     */
    public function hydrate(array $data): array
    {
        return array_map(
            callback: fn (array $row): Residence => $this->factory->make(data: $row),
            array: $data,
        );
    }
}
