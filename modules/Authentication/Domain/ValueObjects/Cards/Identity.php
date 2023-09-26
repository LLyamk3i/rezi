<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\ValueObjects\Cards;

use Modules\Shared\Domain\ValueObjects\File;

final class Identity
{
    public function __construct(
        public readonly File $recto,
        public readonly File $verso,
    ) {
        //
    }

    /**
     * @return array{recto:File,verso:File}
     */
    public function toArray(): array
    {
        return [
            'recto' => $this->recto,
            'verso' => $this->verso,
        ];
    }
}
