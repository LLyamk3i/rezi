<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\ValueObjects\Cards;

use Modules\Shared\Domain\ValueObjects\File;

final readonly class Identity
{
    public function __construct(
        public File $recto,
        public File | null $verso = null,
    ) {
        //
    }

    /**
     * @return array{recto:File,verso:File|null}
     */
    public function toArray(): array
    {
        return [
            'recto' => $this->recto,
            'verso' => $this->verso,
        ];
    }
}
