<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\Repositories;

use Modules\Payment\Domain\Entities\Payment;
use Modules\Shared\Domain\ValueObjects\Ulid;

interface PaymentRepository
{
    public function find(Ulid $id): ?Payment;

    public function create(Payment $payment): bool;

    public function exists(Ulid $payment, Ulid $client): bool;

    public function update(Ulid $id, Payment $payment): bool;
}
