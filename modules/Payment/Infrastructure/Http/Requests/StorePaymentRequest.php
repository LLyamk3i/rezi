<?php

declare(strict_types=1);

namespace Modules\Payment\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Payment\Domain\ValueObjects\Amount;
use Modules\Authentication\Domain\Services\AuthenticatedUserService;
use Modules\Payment\Domain\UseCases\GeneratePaymentKey\GeneratePaymentKeyRequest;
use Modules\Payment\Infrastructure\Rules\ReservationBelongsToAuthenticatedClient;

/**
 * @phpstan-import-type UserRecord from \Modules\Authentication\Domain\Factories\UserFactory
 */
final class StorePaymentRequest extends FormRequest
{
    /**
     * @return array{amount:string,reservation_id:array<int,mixed>}
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|integer',
            'reservation_id' => ['required', 'string', new ReservationBelongsToAuthenticatedClient],
        ];
    }

    /**
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function approved(): GeneratePaymentKeyRequest
    {
        /** @var AuthenticatedUserService $service */
        $service = resolve(AuthenticatedUserService::class);

        return new GeneratePaymentKeyRequest(
            client: $service->run(),
            amount: new Amount(value: $this->integer(key: 'amount')),
            reservation: new Ulid(value: (string) $this->str(key: 'reservation_id')),
        );
    }
}
