<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;

/**
 * @phpstan-type RatingFormat array{id:string,value:float,comment:string,residence?:string|null}
 */
final readonly class Rating
{
    public function __construct(
        public Ulid $id,
        public float $value,
        public \DateTime $date,
        public string $comment,
        public Owner | null $owner = null,
        public Ulid | null $residence = null,
    ) {
        //
    }

    /**
     * @phpstan-return RatingFormat
     */
    public function __serialize(): array
    {
        return [
            'id' => $this->id->value,
            'value' => $this->value,
            'comment' => $this->comment,
            'residence' => $this->residence?->value,
            'created_at' => $this->date->format(format: 'Y-m-d H:m:i'),
        ];
    }
}
