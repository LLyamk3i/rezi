<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Factories;

use Modules\Residence\Domain\Entities\Type;
use Modules\Shared\Domain\ValueObjects\Ulid;

/**
 * @phpstan-type TypeRecord array{id:string,name:string,type_id?:string,type_name?:string}
 */
final class TypeFactory
{
    /**
     * @phpstan-param TypeRecord $data
     *
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     * @throws \InvalidArgumentException
     */
    public function make(array $data): Type
    {
        return new Type(
            name: $data['type_name'] ?? $data['name'],
            id: new Ulid(value: $data['type_id'] ?? $data['id']),
        );
    }
}
