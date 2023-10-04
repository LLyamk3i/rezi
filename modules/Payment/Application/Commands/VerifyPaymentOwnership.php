<?php

declare(strict_types=1);

namespace Modules\Payment\Application\Commands;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Payment\Domain\Repositories\PaymentRepository;
use Modules\Payment\Domain\Commands\VerifyPaymentOwnershipContract;

final class VerifyPaymentOwnership implements VerifyPaymentOwnershipContract
{
    public function __construct(
        private readonly PaymentRepository $repository,
    ) {
        //
    }

    public function handle(Ulid $payment, Ulid $client): bool
    {
        return $this->repository->exists(payment: $payment, client: $client);
    }
}
