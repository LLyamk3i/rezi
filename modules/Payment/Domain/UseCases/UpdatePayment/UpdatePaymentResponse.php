<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\UseCases\UpdatePayment;

final class UpdatePaymentResponse
{
    public function __construct(
        public readonly int $status,
        public readonly bool $failed,
        public readonly string $message,
        public readonly ?string $payment_id = null,
        public readonly ?string $payment_status = null,
    ) {
    }
}
