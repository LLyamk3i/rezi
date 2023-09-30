<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\UseCases\GeneratePaymentKey;

use Modules\Shared\Domain\UseCases\Response;

interface GeneratePaymentKeyContract
{
    public function execute(GeneratePaymentKeyRequest $request): Response;
}
