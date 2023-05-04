<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Reservation\Infrastructure\Database\Factories\ReservationFactory;

class Reservation extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    public static function factory(): ReservationFactory
    {
        return ReservationFactory::new();
    }
}
