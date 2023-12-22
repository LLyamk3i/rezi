<?php

declare(strict_types=1);

namespace Modules\Residence\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;

use function Modules\Shared\Infrastructure\Helpers\array_filter_filled;

/**
 * @phpstan-type RatingFormat array{id:string,value:string,comment:string,residence?:string}
 */
final readonly class Rating
{
    public function __construct(
        public Ulid $id,
        public float $value,
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
        return array_filter_filled(array: [
            'id' => $this->id->value,
            'value' => $this->value,
            'comment' => $this->comment,
            'residence' => $this->residence?->value,
        ]);
    }
}
