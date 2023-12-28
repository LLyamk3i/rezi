<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;

/**
 * @phpstan-type OwnerFormat array{id:string,name:string,avatar:string}
 */
final readonly class Owner
{
    public function __construct(
        public Ulid $id,
        public string $name,
        public string | null $avatar = null,
    ) {
        //
    }

    /**
     * @phpstan-return OwnerFormat
     */
    public function __serialize(): array
    {
        return ['id' => $this->id->value, 'name' => $this->name, 'avatar' => $this->avatar];
    }
}
