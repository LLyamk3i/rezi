<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\UseCases\UpdatePayment;

use Modules\Shared\Domain\Enums\Http;

final readonly class UpdatePaymentResponse
{
    public function __construct(
        public Http $status,
        public bool $failed,
        public string $message,
        public null | string $payment_id = null,
        public null | string $payment_status = null,
    ) {
    }
}
