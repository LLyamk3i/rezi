<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Factories;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Residence\Domain\Entities\Feature;

/**
 * @phpstan-type FeatureRecord array{id:string,name:string,icon?:string}
 */
final class FeatureFactory
{
    /**
     * @phpstan-param FeatureRecord $data
     *
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     * @throws \InvalidArgumentException
     */
    public function make(array $data): Feature
    {
        return new Feature(
            name: $data['name'],
            icon: $data['icon'] ?? null,
            id: new Ulid(value: $data['id']),
        );
    }
}
