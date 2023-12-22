<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Residence\Infrastructure\Database\Factories\RatingFactory;

final class Rating extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    protected $guarded = ['id', 'updated_at', 'created_at'];

    public static function factory(): RatingFactory
    {
        return new RatingFactory();
    }
}
