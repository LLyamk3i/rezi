<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Supports;

use Illuminate\Support\Facades\DB;
use Modules\Shared\Domain\Supports\TransactionContract;

final class Transaction implements TransactionContract
{
    public function start(): void
    {
        DB::beginTransaction();
    }

    public function commit(): void
    {
        DB::commit();
    }

    public function cancel(): void
    {
        DB::rollBack();
    }
}
