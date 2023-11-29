<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\UseCases\UpdatePayment;

final readonly class UpdatePaymentResponse
{
    public function __construct(
        public int $status,
        public bool $failed,
        public string $message,
        public null | string $payment_id = null,
        public null | string $payment_status = null,
    ) {
    }
}
