<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\UseCases\UpdatePayment;

interface UpdatePaymentContract
{
    public function execute(UpdatePaymentRequest $request): UpdatePaymentResponse;
}
