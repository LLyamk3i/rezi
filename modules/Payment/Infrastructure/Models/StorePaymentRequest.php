<?php

declare(strict_types=1);

namespace Modules\Payment\Infrastructure\Models;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Payment\Domain\ValueObjects\Amount;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Authentication\Domain\Factories\UserFactory;
use Modules\Payment\Domain\UseCases\GeneratePaymentKey\GeneratePaymentKeyRequest;

/**
 * @phpstan-import-type UserRecord from \Modules\Authentication\Domain\Factories\UserFactory
 */
final class StorePaymentRequest extends FormRequest
{
    /**
     * @return array{amount:string,reservation_id}
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|integer',
            'reservation_id' => 'required|exists:reservations,id',
        ];
    }

    public function approved(): GeneratePaymentKeyRequest
    {
        $user = $this->user();
        if (! ($user instanceof User)) {
            throw new \RuntimeException(message: 'Account not found', code: 1);
        }
        /** @phpstan-var UserRecord $data */
        $data = $user->toArray();

        return new GeneratePaymentKeyRequest(
            amount: new Amount(value: $this->integer(key: 'amount')),
            client: (new UserFactory())->make(data: $data),
            reservation: new Ulid(value: (string) $this->str(key: 'reservation_id')),
        );
    }
}
