<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Reservation\Infrastructure\Database\Factories\ReservationFactory;

final class Reservation extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    protected $casts = [
        'checkin_at' => 'datetime:Y-m-d H:i:s',
        'checkout_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function factory(): ReservationFactory
    {
        return ReservationFactory::new();
    }
}
