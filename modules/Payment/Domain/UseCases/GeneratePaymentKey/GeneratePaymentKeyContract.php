<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\UseCases\GeneratePaymentKey;

interface GeneratePaymentKeyContract
{
    public function execute(GeneratePaymentKeyRequest $request): GeneratePaymentKeyResponse;
}
