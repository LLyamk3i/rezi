<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Factories;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Residence\Domain\Entities\Rating;

/**
 * @phpstan-type RatingRecord array{id:string,created_at:string,value:float,comment:string,owner:\Modules\Residence\Domain\Entities\Owner,residence:string}
 */
final class RatingFactory
{
    /**
     * @phpstan-param RatingRecord $data
     *
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     * @throws \InvalidArgumentException
     */
    public function make(array $data): Rating
    {
        return new Rating(
            value: $data['value'],
            comment: $data['comment'],
            owner: $data['owner'] ?? null,
            id: new Ulid(value: $data['id']),
            date: new \DateTime(datetime: $data['created_at']),
            residence: isset($data['residence']) ? new Ulid(value: $data['residence']) : null,
        );
    }
}
