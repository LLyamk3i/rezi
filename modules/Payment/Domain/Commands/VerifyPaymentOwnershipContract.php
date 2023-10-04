<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\Commands;

use Modules\Shared\Domain\ValueObjects\Ulid;

interface VerifyPaymentOwnershipContract
{
    public function handle(Ulid $payment, Ulid $client): bool;
}
