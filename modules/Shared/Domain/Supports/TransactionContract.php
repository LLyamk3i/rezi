<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Supports;

interface TransactionContract
{
    public function start(): void;

    public function commit(): void;

    public function cancel(): void;
}
