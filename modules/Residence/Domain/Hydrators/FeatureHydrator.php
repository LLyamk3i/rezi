<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Hydrators;

use Modules\Residence\Domain\Entities\Feature;
use Modules\Shared\Domain\Contracts\HydratorContract;
use Modules\Residence\Domain\Factories\FeatureFactory;

/**
 * @phpstan-import-type FeatureRecord from \Modules\Residence\Domain\Factories\FeatureFactory
 *
 * @implements HydratorContract<FeatureRecord,Feature>
 */
final readonly class FeatureHydrator implements HydratorContract
{
    public function __construct(
        private FeatureFactory $factory,
    ) {
        //
    }

    /**
     * @phpstan-param array<int,FeatureRecord> $data
     *
     * @return array<int,Feature>
     */
    public function hydrate(array $data): array
    {
        return array_map(
            callback: fn (array $row): Feature => $this->factory->make(data: $row),
            array: $data,
        );
    }
}
