<?php

declare(strict_types=1);

namespace Modules\Payment\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Payment\Domain\Entities\Payment;
use Modules\Payment\Domain\Repositories\PaymentRepository;

final class EloquentPaymentRepository implements PaymentRepository
{
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
}
