<?php

declare(strict_types=1);

namespace Modules\Payment\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Payment\Infrastructure\Http\Requests\StorePaymentRequest;
use Modules\Payment\Infrastructure\Http\Requests\UpdatePaymentRequest;
use Modules\Payment\Domain\UseCases\UpdatePayment\UpdatePaymentContract;
use Modules\Payment\Domain\UseCases\GeneratePaymentKey\GeneratePaymentKeyContract;

final class PaymentController
{
    /**
     * @see \Modules\Payment\Application\UseCases\GeneratePaymentKey
     *
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function store(StorePaymentRequest $request, GeneratePaymentKeyContract $payment): JsonResponse
    {
        $response = $payment->execute(request: $request->approved());

        return response()->json(
            status: $response->status->value,
            data: [
                'success' => ! $response->failed,
                'message' => $response->message,
                'payment_id' => $response->id,
                'amount' => $response->amount,
            ]
        );
    }

    /**
     * @see \Modules\Payment\Application\UseCases\UpdatePayment
     *
     * @throws \Exception
     */
    public function update(UpdatePaymentRequest $request, UpdatePaymentContract $update): JsonResponse
    {
        $response = $update->execute(request: $request->approved());

        return response()->json(
            status: $response->status->value,
            data: array_filter(array: [
                'success' => ! $response->failed,
                'message' => $response->message,
                'payment_id' => $response->payment_id,
                'status' => $response->payment_status,
            ])
        );
    }
}
