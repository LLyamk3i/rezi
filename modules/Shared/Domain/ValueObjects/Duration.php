<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObjects;

final readonly class Duration
{
    public function __construct(
        public \DateTime $start,
        public \DateTime $end,
    ) {
        //
    }

    public function __serialize(): array
    {
        return [
            'start' => $this->start->format(format: 'Y-m-d H:i:s'),
            'end' => $this->end->format(format: 'Y-m-d H:i:s'),
        ];
    }

    public function length(): int
    {
        return $this->start->diff(targetObject: $this->end)->d;
    }
}
