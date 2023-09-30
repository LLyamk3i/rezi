<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\Commands;

use Modules\Payment\Domain\Entities\Payment;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Payment\Domain\ValueObjects\Amount;

interface GeneratePaymentContract
{
    public function handle(Amount $amount, Ulid $client, Ulid $reservation): Payment;
}
