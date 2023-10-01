<?php

declare(strict_types=1);

namespace Modules\Payment\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Payment\Infrastructure\Models\StorePaymentRequest;
use Modules\Payment\Domain\UseCases\GeneratePaymentKey\GeneratePaymentKeyContract;

/**
 * @see \Modules\Payment\Application\UseCases\GeneratePaymentKey
 */
final class PaymentController
{
    public function store(StorePaymentRequest $request, GeneratePaymentKeyContract $payment): JsonResponse
    {
        $response = $payment->execute(request: $request->approved());

        return response()->json(status: $response->status, data: [
            'success' => ! $response->failed,
            'message' => $response->message,
            'id' => $response->id,
            'amount' => $response->amount,
        ]);
    }
}
