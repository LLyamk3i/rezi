<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;

/**
 * @phpstan-type TypeFormat array{id:string,name:string}
 */
final readonly class Type
{
    public function __construct(
        public Ulid $id,
        public string $name,
    ) {
        //
    }

    /**
     * @phpstan-return TypeFormat
     */
    public function __serialize(): array
    {
        return [
            'name' => $this->name,
            'id' => $this->id->value,
        ];
    }
}
