<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Concerns;

trait Serializable
{
    public function __serialize(): array
    {
        return $this->__serialize();
    }
}
