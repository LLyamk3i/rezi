<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\UseCases\UpdatePayment;

use Modules\Payment\Domain\Enums\Status;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Domain\Entities\User;

final readonly class UpdatePaymentRequest
{
    public function __construct(
        public User $client,
        public Status $status,
        public Ulid $payment,
    ) {
        //
    }
}
