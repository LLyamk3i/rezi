<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;

/**
 * @phpstan-type FeatureFormat array{id:string,name:string,icon?:string}
 */
final readonly class Feature
{
    public function __construct(
        public Ulid $id,
        public string $name,
        public string | null $icon = null,
    ) {
        //
    }

    /**
     * @phpstan-return FeatureFormat
     */
    public function __serialize(): array
    {
        return [
            'id' => $this->id->value,
            'name' => $this->name,
            'icon' => $this->icon,
        ];
    }
}
