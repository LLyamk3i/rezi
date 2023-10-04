<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\UseCases\UpdatePayment;

use Modules\Payment\Domain\Enums\Status;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Domain\Entities\User;

final class UpdatePaymentRequest
{
    public function __construct(
        public readonly User $client,
        public readonly Status $status,
        public readonly Ulid $payment,
    ) {
        //
    }
}
