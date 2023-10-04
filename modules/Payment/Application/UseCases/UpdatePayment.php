<?php

declare(strict_types=1);

namespace Modules\Payment\Application\UseCases;

use Modules\Shared\Domain\Enums\Http;
use Modules\Payment\Domain\Enums\Status;
use Modules\Payment\Domain\Entities\Payment;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Translation\Translator;
use Modules\Payment\Domain\Repositories\PaymentRepository;
use Modules\Payment\Domain\UseCases\UpdatePayment\UpdatePaymentRequest;
use Modules\Payment\Domain\UseCases\UpdatePayment\UpdatePaymentContract;
use Modules\Payment\Domain\UseCases\UpdatePayment\UpdatePaymentResponse;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final readonly class UpdatePayment implements UpdatePaymentContract
{
    public function __construct(
        private PaymentRepository $repository,
        private Translator $translator,
        private ExceptionHandler $exception,
    ) {
        //
    }

    public function execute(UpdatePaymentRequest $request): UpdatePaymentResponse
    {
        $payment = $this->repository->find(id: $request->payment);

        if (\is_null(value: $payment)) {
            return new UpdatePaymentResponse(
                status: Http::NOT_FOUND->value,
                failed: true,
                message: string_value(value: $this->translator->get(key: 'payment::messages.update.errors.missing')),
            );
        }

        $updated = new Payment(
            id: $payment->id,
            amount: $payment->amount,
            user: $payment->user,
            reservation: $payment->reservation,
            status: $request->status,
            payed: $request->status === Status::Completed ? new \DateTime() : null,
        );

        try {
            $this->repository->update(id: $request->payment, payment: $updated);
        } catch (\Throwable $throwable) {
            $this->exception->report(e: $throwable);

            return new UpdatePaymentResponse(
                status: Http::INTERNAL_SERVER_ERROR->value,
                failed: true,
                message: string_value(value: $this->translator->get(key: 'payment::messages.update.errors.server')),
            );
        }

        return new UpdatePaymentResponse(
            status: Http::ACCEPTED->value,
            failed: false,
            message: string_value(value: $this->translator->get(key: 'payment::messages.update.success')),
            payment_id: $updated->id->value,
            payment_status: $updated->status->value,
        );
    }
}
