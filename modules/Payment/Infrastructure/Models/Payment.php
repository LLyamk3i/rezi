<?php

declare(strict_types=1);

namespace Modules\Payment\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Infrastructure\Database\Factories\PaymentFactory;

final class Payment extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    public static function factory(): PaymentFactory
    {
        return PaymentFactory::new();
    }
}
