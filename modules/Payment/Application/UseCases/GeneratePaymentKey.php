<?php

declare(strict_types=1);

namespace Modules\Payment\Application\UseCases;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Translation\Translator;
use Modules\Payment\Domain\Repositories\PaymentRepository;
use Modules\Payment\Domain\Commands\GeneratePaymentContract;
use Modules\Payment\Domain\UseCases\GeneratePaymentKey\GeneratePaymentKeyRequest;
use Modules\Payment\Domain\UseCases\GeneratePaymentKey\GeneratePaymentKeyContract;
use Modules\Payment\Domain\UseCases\GeneratePaymentKey\GeneratePaymentKeyResponse;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final readonly class GeneratePaymentKey implements GeneratePaymentKeyContract
{
    public function __construct(
        private GeneratePaymentContract $generator,
        private PaymentRepository $repository,
        private ExceptionHandler $exception,
        private Translator $translator,
    ) {
        //
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function execute(GeneratePaymentKeyRequest $request): GeneratePaymentKeyResponse
    {
        $payment = $this->generator->handle(
            amount: $request->amount,
            client: $request->client->id,
            reservation: $request->reservation,
        );

        try {
            $this->repository->create(payment: $payment);
        } catch (\Throwable $throwable) {
            $this->exception->report(e: $throwable);

            return new GeneratePaymentKeyResponse(
                status: 500,
                failed: true,
                message: string_value(value: $this->translator->get(key: 'payment::messages.initialization.error')),
            );
        }

        return new GeneratePaymentKeyResponse(
            status: 201,
            failed: false,
            id: $payment->id->value,
            amount: $payment->amount->value,
            message: string_value(value: $this->translator->get(key: 'payment::messages.initialization.success')),
        );
    }
}
