<?php

declare(strict_types=1);

namespace Modules\Payment\Application\Commands;

use Modules\Payment\Domain\Enums\Status;
use Modules\Payment\Domain\Entities\Payment;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Payment\Domain\ValueObjects\Amount;
use Modules\Shared\Domain\Contracts\GeneratorContract;
use Modules\Payment\Domain\Commands\GeneratePaymentContract;

final readonly class GeneratePayment implements GeneratePaymentContract
{
    public function __construct(
        private GeneratorContract $ulid,
    ) {
    }

    public function handle(Amount $amount, Ulid $client, Ulid $reservation): Payment
    {
        return new Payment(
            id: new Ulid(value: $this->ulid->generate()),
            amount: $amount,
            user: $client,
            reservation: $reservation,
            status: Status::Pending,
            payed: null,
        );
    }
}
