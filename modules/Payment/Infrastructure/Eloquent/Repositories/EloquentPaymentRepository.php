<?php

declare(strict_types=1);

namespace Modules\Payment\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Payment\Domain\Entities\Payment;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Application\Repositories\Repository;
use Modules\Payment\Application\Factories\PaymentFactory;
use Modules\Payment\Domain\Repositories\PaymentRepository;

/**
 * @phpstan-import-type PaymentRecord from \Modules\Payment\Application\Factories\PaymentFactory
 */
final readonly class EloquentPaymentRepository implements PaymentRepository
{
    public function __construct(
        private Repository $parent,
        private PaymentFactory $factory,
    ) {
        //
    }

    public function find(Ulid $id): ?Payment
    {
        /** @phpstan-var PaymentRecord|null $result */
        $result = $this->parent->find(
            query: DB::table(table: 'payments')->where('id', $id->value)
        );

        return \is_array(value: $result)
            ? $this->factory->make(data: $result)
            : null;
    }

    public function create(Payment $payment): bool
    {
        return DB::table(table: 'payments')->insert(values: [
            'id' => $payment->id->value,
            'amount' => $payment->amount->value,
            'status' => $payment->status->value,
            'reservation_id' => $payment->reservation->value,
            'user_id' => $payment->user->value,
            'payed_at' => $payment->payed,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function exists(Ulid $payment, Ulid $client): bool
    {
        return DB::table(table: 'payments')
            ->where(['id' => $payment->value, 'user_id' => $client->value])
            ->exists();
    }

    public function update(Ulid $id, Payment $payment): bool
    {
        $affected = DB::table(table: 'payments')->where('id', $id->value)->update(values: [
            'status' => $payment->status->value,
            'payed_at' => $payment->payed,
            'updated_at' => now(),
        ]);

        return $affected === 1;
    }
}
