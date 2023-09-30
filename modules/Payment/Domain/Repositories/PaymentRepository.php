<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\Repositories;

use Modules\Payment\Domain\Entities\Payment;

interface PaymentRepository
{
    public function create(Payment $payment): bool;
}
