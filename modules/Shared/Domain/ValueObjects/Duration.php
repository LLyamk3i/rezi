<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObjects;

final class Duration
{
    public function __construct(
        public readonly \DateTime $start,
        public readonly \DateTime $end,
    ) {
        //
    }

    public function length(): int
    {
        return $this->start->diff(targetObject: $this->end)->d;
    }
}
