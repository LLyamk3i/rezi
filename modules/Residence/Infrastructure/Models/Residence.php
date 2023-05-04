<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Residence\Infrastructure\Database\Factories\ResidenceFactory;

final class Residence extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    public static function factory(): ResidenceFactory
    {
        return new ResidenceFactory();
    }
}
