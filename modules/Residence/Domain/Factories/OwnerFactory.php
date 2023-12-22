<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Factories;

use Modules\Residence\Domain\Entities\Owner;
use Modules\Shared\Domain\ValueObjects\Ulid;

/**
 * @phpstan-type OwnerRecord array{id:string,name:string,avatar?:string,surname:string,forename:string,owner_id?:string,owner_avatar?:string,owner_surname?:string,owner_forename?:string}
 */
final class OwnerFactory
{
    /**
     * @phpstan-param OwnerRecord $data
     *
     * @throws \InvalidArgumentException
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function make(array $data): Owner
    {
        return new Owner(
            name: $this->name(data: $data),
            id: new Ulid(value: $data['owner_id'] ?? $data['id']),
            avatar: $data['owner_avatar'] ?? $data['avatar'] ?? null,
        );
    }

    /**
     * @phpstan-param OwnerRecord $data
     */
    private function name(array $data): string
    {
        return sprintf('%s %s', $data['owner_forename'] ?? $data['forename'], $data['owner_surname'] ?? $data['surname']);
    }
}
