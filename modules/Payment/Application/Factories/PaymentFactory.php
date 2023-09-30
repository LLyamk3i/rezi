<?php

declare(strict_types=1);

namespace Modules\Payment\Application\Factories;

use Modules\Payment\Domain\Enums\Status;
use Modules\Payment\Domain\Entities\Payment;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Payment\Domain\ValueObjects\Amount;

/**
 * @phpstan-type PaymentRecord array{id:string,amount:integer,user_id:string,reservation_id:string,status:string,payed_at:string}
 */
final class PaymentFactory
{
    /**
     * @phpstan-param PaymentRecord $data
     */
    public function make(array $data): Payment
    {
        return new Payment(
            id: new Ulid(value: $data['id']),
            amount: new Amount(value: $data['amount']),
            user: new Ulid(value: $data['user_id']),
            reservation: new Ulid(value: $data['reservation_id']),
            status: Status::from(value: $data['status']),
            payed: \is_null(value: $data['payed_at']) ? null : new \DateTime(datetime: $data['payed_at']),
        );
    }
}
