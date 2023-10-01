<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\UseCases\GeneratePaymentKey;

final class GeneratePaymentKeyResponse
{
    public function __construct(
        public readonly int $status,
        public readonly bool $failed,
        public readonly string $message,
        public readonly ?string $id = null,
        public readonly ?int $amount = null,
    ) {
        //
    }
}
