<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\UseCases\GeneratePaymentKey;

use Modules\Shared\Domain\Enums\Http;

final readonly class GeneratePaymentKeyResponse
{
    public function __construct(
        public Http $status,
        public bool $failed,
        public string $message,
        public null | string $id = null,
        public null | int $amount = null,
    ) {
        //
    }
}
